<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Guest;
use App\Form\GuestType;

class GuestController extends AbstractController
{

    #[Route('/guest/update-summary', name: 'update_guest_summary')]
    public function updateSummaryAction(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        /** 
         * @var User $user 
         * */
        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }


        // Aktualizuj dane podsumowujące
        $summary = $entityManager->getRepository(Guest::class)->getSummaryOfGuest($userId);



        // Zwróć dane jako JSON
        return new JsonResponse($summary);
    }




    #[Route('/guest', name: 'app_guest')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
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
                $summary = $entityManager->getRepository(Guest::class)->getSummaryOfGuest($userId);
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


    #[Route('/guest/confirmed/{id}', name: 'guest_confirmed')]

    public function switchStatusOfConfirmed(
        $id,
        EntityManagerInterface $entityManager
    ): Response {

        $guest = $entityManager->getRepository(Guest::class)->find($id);

        $guest->setIsConfirmed(!$guest->isIsConfirmed());

        $entityManager->persist($guest);
        $entityManager->flush();

        return $this->redirectToRoute('app_guest');
    }

    #[Route('/guest/transport/{id}', name: 'guest_tranpsport')]

    public function switchStatusOfTransport(
        $id,
        EntityManagerInterface $entityManager
    ): Response {

        $guest = $entityManager->getRepository(Guest::class)->find($id);

        $guest->setTransport(!$guest->isTransport());

        $entityManager->persist($guest);
        $entityManager->flush();

        return $this->redirectToRoute('app_guest');
    }

    #[Route('/guest/acc/{id}', name: 'guest_acc')]

    public function switchStatusOfAcc(
        $id,
        EntityManagerInterface $entityManager
    ): Response {

        $guest = $entityManager->getRepository(Guest::class)->find($id);

        $guest->setIsAccommodation(!$guest->isIsAccommodation());

        $entityManager->persist($guest);
        $entityManager->flush();

        return $this->redirectToRoute('app_guest');
    }

    #[Route('/guest/adult/{id}', name: 'guest_adult')]

    public function switchStatusOfAdult(
        $id,
        EntityManagerInterface $entityManager
    ): Response {

        $guest = $entityManager->getRepository(Guest::class)->find($id);

        $guest->setIsAdult(!$guest->isIsAdult());

        $entityManager->persist($guest);
        $entityManager->flush();

        return $this->redirectToRoute('app_guest');
    }

    #[Route('/guest/baby/{id}', name: 'guest_baby')]

    public function switchStatusOfBaby(
        $id,
        EntityManagerInterface $entityManager
    ): Response {

        $guest = $entityManager->getRepository(Guest::class)->find($id);

        $guest->setIsChildUnderThreeYears(!$guest->isIsChildUnderThreeYears());

        $entityManager->persist($guest);
        $entityManager->flush();

        return $this->redirectToRoute('app_guest');
    }

    #[Route('/guest/child/{id}', name: 'guest_child')]

    public function switchStatusOfChild(
        $id,
        EntityManagerInterface $entityManager
    ): Response {

        $guest = $entityManager->getRepository(Guest::class)->find($id);

        $guest->setIsChildBetweenThreeAndTwelve(!$guest->isIsChildBetweenThreeAndTwelve());

        $entityManager->persist($guest);
        $entityManager->flush();

        return $this->redirectToRoute('app_guest');
    }

    #[Route('/guest/diet/{id}', name: 'guest_diet')]

    public function switchStatusOfDiet(
        $id,
        EntityManagerInterface $entityManager
    ): Response {

        $guest = $entityManager->getRepository(Guest::class)->find($id);

        $guest->setSpecialDiet(!$guest->isSpecialDiet());

        $entityManager->persist($guest);
        $entityManager->flush();

        return $this->redirectToRoute('app_guest');
    }
}
