<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\WeddingSettingsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/settings/email/{id}', name: 'update_email', methods: 'POST')]
    public function updateEmail(Request $request, EntityManagerInterface $entityManager,  $id)
    {
        $email = trim($request->request->get('email'));

        if (empty($email))
            return $this->redirectToRoute('app_settings');

        $user = $entityManager->getRepository(User::class)->find($id);

        $user->setEmail($email);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_settings');
    }

    #[Route('/settings/password/{id}', name: 'update_password', methods: 'POST')]
    public function updatePassword(Request $request, EntityManagerInterface $entityManager,  $id)
    {
        $newPassword = trim($request->request->get('password'));

        if (empty($newPassword))
            return $this->redirectToRoute('app_settings');

        $user = $entityManager->getRepository(User::class)->find($id);

        // Check if user exists
        if (!$user) {
            // Handle the case where the user with the given ID is not found
            return $this->redirectToRoute('app_settings');
        }

        $user->setPassword($newPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_settings');
    }


    #[Route('/settings/brideName/{id}', name: 'update_brideName', methods: 'POST')]
    public function updateBrideName(Request $request, $id, EntityManagerInterface $entityManager)
    {
        $newBrideName = trim($request->request->get('brideName'));

        if (empty($newBrideName))
            return $this->redirectToRoute('app_settings');


        $settings = $entityManager->getRepository(UserProfile::class)->find($id);


        $settings->setBrideName($newBrideName);

        $entityManager->persist($settings);
        $entityManager->flush();

        return $this->redirectToRoute('app_settings');
    }

    #[Route('/settings/groomName/{id}', name: 'update_groomName', methods: 'POST')]
    public function updateGroomName(Request $request, $id, EntityManagerInterface $entityManager)
    {
        $newGroomName = trim($request->request->get('groomName'));

        if (empty($newGroomName))
            return $this->redirectToRoute('app_settings');

        $settings = $entityManager->getRepository(UserProfile::class)->find($id);

        $settings->setGroomName($newGroomName);

        $entityManager->persist($settings);
        $entityManager->flush();

        return $this->redirectToRoute('app_settings');
    }


    #[Route('/settings/date/{id}', name: 'update_date', methods: 'POST')]
    public function updateDate(Request $request, $id, EntityManagerInterface $entityManager)
    {
        $newDate = trim($request->request->get('date'));

        $newDateTime = new \DateTime($newDate);

        if (empty($newDate))
            return $this->redirectToRoute('app_settings');

        $settings = $entityManager->getRepository(UserProfile::class)->find($id);

        var_dump($newDate);

        $settings->setWeddingDate($newDateTime);

        $entityManager->persist($settings);
        $entityManager->flush();

        return $this->redirectToRoute('app_settings');
    }
}
