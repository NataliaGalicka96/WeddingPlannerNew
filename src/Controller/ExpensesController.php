<?php

namespace App\Controller;

use App\Entity\BudgetCategory;
use App\Entity\Expenses;
use App\Entity\UserProfile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Component\HttpFoundation\JsonResponse;

class ExpensesController extends AbstractController
{
    #[Route('/expenses', name: 'app_expenses')]
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

        $dataOfWedding = $entityManager->getRepository(UserProfile::class)->getDataOfWedding($userId);


        $alreadyPaidAndTotalSumGroupByCategory = $entityManager->getRepository(Expenses::class)->getAlreadyPaidAndTotalSumGroupByCategory($userId);
        $allExpenses = $entityManager->getRepository(Expenses::class)->getDetailsOfExpense($userId);
        $allExpensesCategory = $entityManager->getRepository(Expenses::class)->getAllExpensesCategory($userId);
        $sumOfAllExpenses = $entityManager->getRepository(Expenses::class)->sumOfAllExpenses($userId);


        return $this->render('expenses/index.html.twig', [
            'dataOfWedding' => $dataOfWedding,
            'alreadyPaidAndTotalSumGroupByCategory' => $alreadyPaidAndTotalSumGroupByCategory,
            'allExpenses' => $allExpenses,
            'allExpensesCategory' => $allExpensesCategory,
            'sumOfAllExpenses' => $sumOfAllExpenses
        ]);
    }


    #[Route('/budget/update-summary', name: 'update_budget_summary')]
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
        $alreadyPaidAndTotalSumGroupByCategory = $entityManager->getRepository(Expenses::class)->getAlreadyPaidAndTotalSumGroupByCategory($userId);




        // Zwróć dane jako JSON
        return new JsonResponse($alreadyPaidAndTotalSumGroupByCategory);
    }

    #[Route('/budget/set', name: 'set_budget')]
    public function setBudget(Request $request, EntityManagerInterface $entityManager)
    {

        // Pobierz wartość ceny z żądania
        $requestData = json_decode($request->getContent(), true);
        $priceValue = $requestData['budget'];

        $budget = (float) floatval(number_format((float)$priceValue, 2, '.', ''));

        var_dump($priceValue);

        /** 
         * @var User $user 
         * */
        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }

        $is_user_profile = $entityManager->getRepository(UserProfile::class)->check_user_profile($userId);

        echo ($is_user_profile);

        if ($is_user_profile == 1) {
            $entityManager->getRepository(UserProfile::class)->setUserBudget($userId, $budget);
        } else {
            $entityManager->getRepository(UserProfile::class)->addBudget($userId, $budget);
        }



        return $this->redirectToRoute('app_expenses');
    }


    #[Route('/budget/update/price/{id}', name: 'update_price')]
    public function updatePrice(Request $request, $id, EntityManagerInterface $entityManager)
    {

        // Pobierz wartość ceny z żądania
        $requestData = json_decode($request->getContent(), true);
        $priceValue = $requestData['priceOfPodcategory'];


        //$newPrice = trim($request->request->get('priceOfPodcategory'));
        $price = (float) floatval(number_format((float)$priceValue, 2, '.', ''));

        var_dump($priceValue);

        //$price = (float)number_format((float)$newPrice, 2, '.', '');


        /** 
         * @var User $user 
         * */

        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }



        // Aktualizuj cenę w bazie danych
        $entityManager->getRepository(Expenses::class)->updatePrice($userId, $id, $price);

        // Przekieruj gdzieś po zakończeniu
        return $this->redirectToRoute('app_expenses');
    }

    #[Route('/budget/update/alreadyPaid/{id}', name: 'update_alreadypay', methods: "POST")]
    public function updatealreadyPaid(Request $request, $id, EntityManagerInterface $entityManager)
    {

        // Pobierz wartość ceny z żądania
        $requestData = json_decode($request->getContent(), true);
        $priceValue = $requestData['alreadyPayOfPodcategory'];

        $price = (float) floatval(number_format((float)$priceValue, 2, '.', ''));

        /** 
         * @var User $user 
         * */

        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }


        $expense = $entityManager->getRepository(Expenses::class)->updateAlreadyPaid($userId, $id, $price);


        return $this->redirectToRoute('app_expenses');
    }

    #[Route('/budget/addNewExpense', name: 'add_new_expense', methods: 'POST')]
    public function addNewExpense(
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {

        $category = trim($request->request->get('category'));
        $expenseName = trim($request->request->get('expenseName'));
        $price = trim($request->request->get('price'));
        $alreadyPaid = trim($request->request->get('alreadyPaid'));

        $expense = new Expenses();

        $categoryObject = $entityManager->getRepository(BudgetCategory::class)->getIdOfCategory($category);


        $expense->setBudgetCategory($categoryObject);
        $expense->setExpense($expenseName);
        $expense->setPrice($price);
        $expense->setAlreadyPaid($alreadyPaid);
        $expense->setUser($this->getUser());


        $errors = $validator->validate($expense);

        if (count($errors) == 0) {

            $entityManager->persist($expense);
            $entityManager->flush();
            $this->addFlash('success', "Dodano nowy wydatek!");
            return $this->redirectToRoute('app_expenses');
        } else {
            $this->addFlash('error', "Nie udało się dodać wydatku!");
            return $this->redirectToRoute('app_expenses');
        }
    }


    #[Route('/budget/save/{id}', name: 'budget_save', methods: ["POST"])]
    public function save(Request $request, $id, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        /** 
         * @var User $user 
         * */

        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }

        if ($request->isMethod('POST')) {
            $price = $request->request->get('priceOfPodcategory');
            $alreadyPaid = $request->request->get('alreadyPayOfPodcategory');
            $entryIdPrice = $request->request->get('entryIdPrice');
            $entryIdAlreadyPaid = $request->request->get('entryIdAlreadyPaid');

            $newAlreadyPaid = (float)number_format((float)$alreadyPaid, 2, '.', '');
            $expenseAlreadyPaid = $entityManager->getRepository(Expenses::class)->updateAlreadyPaid($userId, $id, $newAlreadyPaid);

            $newPrice = (float)number_format((float)$price, 2, '.', '');
            $expensePrice = $entityManager->getRepository(Expenses::class)->updatePrice($userId, $id, $newPrice);
        }

        return $this->redirectToRoute('app_expenses');
    }
}
