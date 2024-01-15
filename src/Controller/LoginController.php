<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $utils): Response
    {
        /*if ($this->getUser()) {

            return $this->redirectToRoute('app_wedding_planner_page');
        }*/

        $lastUserName = $utils->getLastUsername();
        $error = $utils->getLastAuthenticationError();

        if ($error) {
            $this->addFlash('error', "Błędne dane, nie udało się zalogować. Spróbuj jeszcze raz!");
        }

        return $this->render('login/index.html.twig', [
            'lastUsername' => $lastUserName,
            'error' => $error,

        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): Response
    {
        $this->addFlash('info', "Wylogowałeś się ze swojego konta!");
        return $this->redirectToRoute('app_wedding_planner_page');
    }
}
