<?php

namespace App\Controller;

use App\Entity\UserProfile;
use App\Form\WeddingSettingsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

class SettingsController extends AbstractController
{
    #[Route('/settings', name: 'app_settings')]
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

        $user = $this->getUser();

        $email = $user->getUserIdentifier();

        $dataWedding = $entityManager->getRepository(UserProfile::class)->getDataOfWedding($userId);

        $form = $this->createForm(WeddingSettingsType::class);

        return $this->render('settings/index.html.twig', [
            'dataWedding' => $dataWedding,
            'email' => $email,
            'form' => $form->createView()
        ]);
    }
}
