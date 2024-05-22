<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserProfile;
use App\Form\WeddingSettingsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;


class MainPageAfterLogInController extends AbstractController
{
    #[Route('/main/page', name: 'app_main_page')]
    public function index(
        EntityManagerInterface $entityManager,
        Request $request,
        ValidatorInterface $validator
    ): Response {


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

        
        //$em = $this->getDoctrine()->getManager();

        $dataOfWedding = $entityManager->getRepository(UserProfile::class)->getDataOfWedding($userId);

        //dd($dataOfWedding);

        $form = $this->createForm(WeddingSettingsType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {

                $is_user_profile = $entityManager->getRepository(UserProfile::class)->check_user_profile($userId);

                $brideName = $form->get('bride_name')->getData();
                $groomName = $form->get('groom_name')->getData();
                $date = $form->get('wedding_date')->getData();


                if ($is_user_profile == 1) {
                    $entityManager->getRepository(UserProfile::class)->setWeddingData($userId, $brideName, $groomName, $date);
                } else {
                    $entityManager->getRepository(UserProfile::class)->addWeddingData($userId, $brideName, $groomName, $date);
                }

                /*
                $weddingDetail = new UserProfile();
                $weddingDetail->setUser($this->getUser());
                $weddingDetail->setBrideName($form->get('bride_name')->getData());
                $weddingDetail->setGroomName($form->get('groom_name')->getData());
                $weddingDetail->setWeddingDate($form->get('wedding_date')->getData());
                $errors = $validator->validate($weddingDetail);

                if (count($errors) == 0) {

                    $entityManager->persist($weddingDetail);
                    $entityManager->flush();
                    $this->addFlash('success', "Ustawiono datę ślubu oraz imiona Państwa Młodych!");
                    return $this->redirectToRoute('app_main_page');
                } else {
                    $this->addFlash('error', 'Nie udało się ustawić danych!');
                }*/
            }
        }
        
        return $this->render('main_page/index.html.twig', [

            'form' => $form->createView(),
            'dataWedding' => $dataOfWedding

        ]);

    }
}
