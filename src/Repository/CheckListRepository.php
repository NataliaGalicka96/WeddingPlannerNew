<?php

namespace App\Repository;

use App\Entity\CheckList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CheckList>
 *
 * @method CheckList|null find($id, $lockMode = null, $lockVersion = null)
 * @method CheckList|null findOneBy(array $criteria, array $orderBy = null)
 * @method CheckList[]    findAll()
 * @method CheckList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CheckList::class);
    }

    public function getTaskAssignedToUser($userId)
    {

        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT cl.*, clc.name
        FROM check_list cl
        JOIN check_list_category clc ON clc.id = cl.check_list_category_id
        WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $userId]);


        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return CheckList[] Returns an array of CheckList objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CheckList
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
