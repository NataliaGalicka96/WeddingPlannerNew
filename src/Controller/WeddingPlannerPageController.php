<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeddingPlannerPageController extends AbstractController
{
    #[Route('/', name: 'app_wedding_planner_page')]
    public function index(): Response
    {
        return $this->render('wedding_planner_page/index.html.twig', [
            'controller_name' => 'WeddingPlannerPageController',
        ]);
    }
}
