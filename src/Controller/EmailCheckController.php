<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailCheckController extends AbstractController
{

    public function __construct(private MailerInterface $mailer)
    {
    }

    #[Route('/email/check', name: 'app_email_check')]
    public function index(): Response
    {

        $email = (new Email())
            ->from('natalia.nauka96@gmail.com')
            ->to('n.chychlowska@gmail.com')
            ->subject('Testowy e-mail z Symfony 6')
            ->text('To jest treść testowego e-maila wysłanego z Symfony 6.');

        $this->mailer->send($email);

        return $this->render('email_check/index.html.twig', [
            'controller_name' => 'EmailCheckController',
        ]);
    }
}
