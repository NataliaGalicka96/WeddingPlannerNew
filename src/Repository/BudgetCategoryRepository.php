<?php

namespace App\Repository;

use App\Entity\BudgetCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BudgetCategory>
 *
 * @method BudgetCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method BudgetCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method BudgetCategory[]    findAll()
 * @method BudgetCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BudgetCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BudgetCategory::class);
    }

    public function getIdOfCategory($categoryName): ?BudgetCategory
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :val')
            ->setParameter('val', $categoryName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return BudgetCategory[] Returns an array of BudgetCategory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BudgetCategory
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
