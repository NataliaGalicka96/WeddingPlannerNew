<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Guest;
use App\Form\GuestType;

class GuestController extends AbstractController
{
    #[Route('/guest', name: 'app_guest')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if (!$this->getUser()) {
            $this->addFlash('error', "Zaloguj się aby mieć dostęp do tej strony!");
            return $this->redirectToRoute('app_index');
        }

        /** 
         * @var User $user 
         * */
        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }

        $guests = $entityManager->getRepository(Guest::class)->getGuestAssignedToUser($userId);
        $summary = $entityManager->getRepository(Guest::class)->getSummaryOfGuest($userId);


        $form = $this->createForm(GuestType::class, null, array(
            'attr' => array(
                'id' => 'guestForm'
            )
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {
                $newGuest = new Guest();

                $newGuest->setUser($this->getUser());
                $newGuest->setName($form->get('name')->getData());
                $newGuest->setIsConfirmed($form->get('isConfirmed')->getData());
                $newGuest->setIsAccommodation($form->get('isAccommodation')->getData());
                $newGuest->setTransport($form->get('transport')->getData());
                $newGuest->setIsAdult($form->get('isAdult')->getData());
                $newGuest->setIsChildUnderThreeYears($form->get('isChildUnderThreeYears')->getData());
                $newGuest->isIsChildBetweenThreeAndTwelve($form->get('isChildBetweenThreeAndTwelve')->getData());
                $newGuest->setSpecialDiet($form->get('specialDiet')->getData());
                try {
                    $entityManager->persist($newGuest);
                    $entityManager->flush();
                    $this->addFlash('success', "Dodano nowego gościa!");
                    return $this->redirectToRoute('app_guest');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Wystąpił nieoczekiwany błąd!');
                    return $this->redirectToRoute('app_guest');
                }
            }
        }

        return $this->render('guest/index.html.twig', [
            'guestform' => $form->createView(),
            'guests' => $guests,
            'summary' => $summary
        ]);
    }
}
