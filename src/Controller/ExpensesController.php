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

    #[Route('/budget/set', name: 'set_budget', methods: 'POST')]
    public function setBudget(Request $request, EntityManagerInterface $entityManager): Response
    {

        $budgetFromForm = trim($request->request->get('budget'));
        $budget = (float)number_format((float)$budgetFromForm, 2, '.', '');

        /** 
         * @var User $user 
         * */
        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }

        $userProfile = $entityManager->getRepository(UserProfile::class)->setUserBudget($userId, $budget);

        return $this->redirectToRoute('app_expenses');
    }


    #[Route('/budget/update/price/{id}', name: 'update_price', methods: "POST")]
    public function updatePrice(Request $request, $id, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {

        $newPrice = trim($request->request->get('priceOfPodcategory'));
        $price = (float)number_format((float)$newPrice, 2, '.', '');


        /** 
         * @var User $user 
         * */

        $user = $this->getUser();
        if (!empty($user)) {
            $userId = $user->getId();
        }

        $expense = $entityManager->getRepository(Expenses::class)->updatePrice($userId, $id, $price);

        return $this->redirectToRoute('app_expenses');
    }

    #[Route('/budget/update/alreadyPaid/{id}', name: 'update_alreadypay', methods: "POST")]
    public function updatealreadyPaid(Request $request, $id, EntityManagerInterface $entityManager)
    {

        $newPrice = trim($request->request->get('alreadyPayOfPodcategory'));
        $price = (float)number_format((float)$newPrice, 2, '.', '');

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
}
