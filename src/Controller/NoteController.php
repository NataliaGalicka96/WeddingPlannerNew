<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Note;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;


class NoteController extends AbstractController
{
    #[Route('/note', name: 'app_note')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('error', "Zaloguj się aby mieć dostęp do tej strony!");
            return $this->redirectToRoute('app_wedding_planner_page');
        }

        /** 
         * @var User $user 
         * */
        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }

        $noteAssignedToUser = $entityManager->getRepository(Note::class)->getNoteAssignedToUser($userId);

        return $this->render('note/index.html.twig', [
            'notes' =>  $noteAssignedToUser
        ]);
    }

    #[Route('/note/create', name: 'create_new_note', methods: 'POST')]
    public function createNewTask(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {

        $title = $request->request->get('title');
        $content = $request->request->get('content');

        if (empty($title) || empty($content))
            return $this->redirectToRoute('app_note');

        $note = new Note();

        $note->setNote($content);
        $note->setTitle($title);
        $note->setUser($this->getUser());

        $errors = $validator->validate($note);

        if (count($errors) == 0) {
            $entityManager->persist($note);
            $entityManager->flush();
            $this->addFlash('success', "Dodano nową notatkę!");
            return $this->redirectToRoute('app_note');
        } else {
            $this->addFlash('error', "Nie udało się dodać notatki!");
            return $this->redirectToRoute('app_note');
        }
    }

    #[Route('/note/update/note/{id}', name: 'update_note', methods: "POST")]
    public function updateNote(Request $request, $id, EntityManagerInterface $entityManager)
    {

        $newNote = trim($request->request->get('note'));
        $newTitle = trim($request->request->get('titleEdit'));

        /** 
         * @var User $user 
         * */

        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }

        $expense = $entityManager->getRepository(Note::class)->updateNote($userId, $id, $newNote);
        $title = $entityManager->getRepository(Note::class)->updateTitle($userId, $id, $newTitle);

        return $this->redirectToRoute('app_note');
    }

    #[Route('note/delete/{id}', name: 'note_delete')]

    public function delete(Note $id, EntityManagerInterface $entityManager)
    {

        $entityManager->remove($id);
        $entityManager->flush();
        return $this->redirectToRoute('app_note');
    }
}
