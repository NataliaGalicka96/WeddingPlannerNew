<?php

namespace App\Repository;

use App\Entity\DefaultTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DefaultTask>
 *
 * @method DefaultTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method DefaultTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method DefaultTask[]    findAll()
 * @method DefaultTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DefaultTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DefaultTask::class);
    }

//    /**
//     * @return DefaultTask[] Returns an array of DefaultTask objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DefaultTask
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
