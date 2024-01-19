<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\CheckListCategory;
use App\Entity\CheckList;

class CheckListController extends AbstractController
{
    /**
     * Error messages
     *
     * @var array
     */
    public $errorString = [];

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
}
