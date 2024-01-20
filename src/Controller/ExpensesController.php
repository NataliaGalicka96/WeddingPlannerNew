<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpensesController extends AbstractController
{
    #[Route('/expenses', name: 'app_expenses')]
    public function index(): Response
    {
        return $this->render('expenses/index.html.twig', [
            'controller_name' => 'ExpensesController',
        ]);
    }
}
