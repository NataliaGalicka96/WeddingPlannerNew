<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class MainPageAfterLogInController extends AbstractController
{
    #[Route('/main/page', name: 'app_main_page')]
    public function index(): Response
    {


        if (!$this->getUser()) {
            $this->addFlash('error', "Zaloguj się aby mieć dostęp do tej strony!");
            return $this->redirectToRoute('app_wedding_planner_page');
        }


        /** 
         * @var User $user 
         * 
        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }

        $em = $this->getDoctrine()->getManager();
        $dataOfWedding = $em->getRepository(WeddingSettings::class)->getDataOfWedding($userId);
         *
        $form = $this->createForm(WeddingSettingsType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {
                $weddingDetail = new WeddingSettings();

                $weddingDetail->setUser($this->getUser());
                $weddingDetail->setBrideName($form->get('brideName')->getData());
                $weddingDetail->setGroomName($form->get('groomName')->getData());
                $weddingDetail->setDate($form->get('date')->getData());
                $errors = $validator->validate($weddingDetail);

                if (count($errors) == 0) {

                    $em->persist($weddingDetail);
                    $em->flush();
                    $this->addFlash('success', "Ustawiono datę ślubu oraz imiona Państwa Młodych!");
                    return $this->redirectToRoute('app_main_page');
                } else {
                    $this->addFlash('error', 'Nie udało się ustawić danych!');
                }
            }
        }
         */
        return $this->render('main_page/index.html.twig', [

            //'form' => $form->createView(),
            //'dataWedding' => $dataOfWedding

        ]);
    }
}
