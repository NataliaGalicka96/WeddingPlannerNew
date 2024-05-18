<?php

namespace App\Repository;

use App\Entity\Expenses;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expenses>
 *
 * @method Expenses|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expenses|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expenses[]    findAll()
 * @method Expenses[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpensesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expenses::class);
    }

    public function getAllExpensesCategory($userId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT bc.name , e.budget_category_id as category_id
        FROM expenses e
        LEFT JOIN budget_category bc ON e.budget_category_id = bc.id
        WHERE e.user_id = :user_id
        GROUP BY e.budget_category_id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $userId]);


        return $resultSet->fetchAllAssociative();
    }

    public function getDetailsOfExpense($userId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM expenses
        WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $userId]);


        return $resultSet->fetchAllAssociative();
    }




    public function getAlreadyPaidAndTotalSumGroupByCategory($userId)
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT budget_category_id, SUM(COALESCE(already_paid, 0)) as total_paid, SUM(COALESCE(price, 0)) as price
        FROM expenses
        WHERE user_id = :user_id
        GROUP BY budget_category_id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $userId]);


        return $resultSet->fetchAllAssociative();
    }

    public function updatePrice($userId, $id, $price)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE expenses
        SET price = :price
        WHERE user_id = :user_id AND id =:id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'user_id' => $userId,
            'price' => $price,
            'id' => $id
        ]);


        return $resultSet->fetchAllAssociative();
    }


    public function updateAlreadyPaid($userId, $id, $paid)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE expenses
        SET already_paid = :paid
        WHERE user_id = :user_id AND id =:id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'user_id' => $userId,
            'paid' => $paid,
            'id' => $id
        ]);


        return $resultSet->fetchAllAssociative();
    }

    public function sumOfAllExpenses($userId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT SUM(already_paid) as total_paid FROM expenses
        WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $userId]);


        return $resultSet->fetchAllAssociative();
    }



    //    /**
    //     * @return Expenses[] Returns an array of Expenses objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Expenses
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
