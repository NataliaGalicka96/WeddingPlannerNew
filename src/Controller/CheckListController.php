<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\CheckListCategory;
use App\Entity\CheckList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\HttpFoundation\Request;

use TCPDF;



class CheckListController extends AbstractController
{
    /**
     * Error messages
     *
     * @var array
     */
    public $errorString = [];



    #[Route('/check/pdf', name: 'generate_pdf_action')]
    public function generatePdfAction(EntityManagerInterface $entityManager): Response
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Ustawienia czcionki (użyjemy DejaVu Sans)
        $pdf->SetFont('dejavusans', '', 12, '', true);

        // Ustawienia PDF
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Twoje Imię');
        $pdf->SetTitle('Lista zadań do wykonania');
        $pdf->SetSubject('Lista zadań');
        $pdf->SetKeywords('TCPDF, PDF, lista, zadań');

        // Dodaj nową stronę
        $pdf->AddPage();

        // Pobierz dane potrzebne do wygenerowania listy zadań
        $user = $this->getUser();
        if ($user) {
            // Pobieram id zalogowanego użytkownika
            /** 
             * @var User $user 
             */
            $userId = $user->getId();

            $idOfCategory = $entityManager->getRepository(CheckListCategory::class)->getNameAndIdOfCategory();
            $taskAssignedToUser = $entityManager->getRepository(CheckList::class)->getTaskAssignedToUser($userId);

            // Utwórz tabelę z danymi zadań
            $html = '<table border="1">';
            $html .= '<tr><th>Kategoria</th><th>Zadanie</th><th>Status</th></tr>';

            foreach ($idOfCategory as $category) {
                foreach ($taskAssignedToUser as $task) {
                    if ($category['id'] == $task['check_list_category_id']) {
                        $html .= '<tr>';
                        $html .= '<td>' . htmlspecialchars($category['name']) . '</td>';
                        $html .= '<td>' . htmlspecialchars($task['task']) . '</td>';
                        $html .= '<td>' . ($task['status'] ? 'Wykonane' : 'Nie wykonane') . '</td>';
                        $html .= '</tr>';
                    }
                }
            }
            $html .= '</table>';

            // Wydrukowanie HTML do pliku PDF
            $pdf->writeHTML($html, true, false, true, false, '');

            // Wygenerowanie pliku PDF
            $pdf->Output('lista_zadan.pdf', 'D');
        }

        return new Response('', Response::HTTP_NO_CONTENT);
    }


    #[Route('/check/list', name: 'app_check_list')]
    public function index(
        EntityManagerInterface $entityManager,
    ): Response {

        //Sprawdzam, czy jest jakiś użytkownik zalogowany
        if (!$this->getUser()) {
            $this->addFlash('error', "Zaloguj się aby mieć dostęp do tej strony!");
            return $this->redirectToRoute('app_wedding_planner_page');
        }

        //Pobieram id zalogowanego użytkownika
        /** 
         * @var User $user 
         * */
        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }

        //wyświetlamy listę kategorii oraz podkategorii zadań zalogowanego użytkownika
        $idOfCategory = $entityManager->getRepository(CheckListCategory::class)->getNameAndIdOfCategory();

        $taskAssignedToUser = $entityManager->getRepository(CheckList::class)->getTaskAssignedToUser($userId);

        return $this->render('check_list/index.html.twig', [
            'idOfCategory' => $idOfCategory,
            'taskAssignedToUser' => $taskAssignedToUser

        ]);
    }

    #[Route('/check/list/switch-status/{id}', name: 'switch_status')]

    public function switchStatus(
        $id,
        EntityManagerInterface $entityManager
    ): Response {

        $task = $entityManager->getRepository(CheckList::class)->find($id);

        $task->setStatus(!$task->isStatus());

        $entityManager->persist($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_check_list');
    }



    #[Route('check_list/delete/{id}', name: 'task_delete')]
    public function delete(CheckList $id, EntityManagerInterface $entityManager)
    {

        $entityManager->remove($id);
        $entityManager->flush();
        $this->addFlash('success', "Zadanie zostało pomyślnie usunięte");
        return $this->redirectToRoute('app_check_list');
    }

    #[Route('/check/list/create', name: 'create_new_task', methods: 'POST')]
    public function createNewTask(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {

        $categoryId = trim($request->request->get('category'));

        $categoryObject = $entityManager->getRepository(CheckListCategory::class)->getIdOfCategory($categoryId);
        $title = trim($request->request->get('title'));




        if (empty($title))
            return $this->redirectToRoute('app_check_list');

        //$entityManager = $this->getDoctrine()->getManager();

        //dd($categoryId);
        //dd($categoryObject);



        $task = new CheckList();
        $task->setCheckListCategory($categoryObject);
        $task->setTask($title);
        $task->setUser($this->getUser());
        $task->setStatus(0);


        $errors = $validator->validate($task);

        if (count($errors) == 0) {

            $entityManager->persist($task);
            $entityManager->flush();
            $this->addFlash('success', "Dodano nowe zadanie!");
            return $this->redirectToRoute('app_check_list');
        } else {
            $this->addFlash('error', "Nie udało się dodać zadania!");
            return $this->redirectToRoute('app_check_list');
        }
    }
}
