<?php

namespace App\Repository;

use App\Entity\Guest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Guest>
 *
 * @method Guest|null find($id, $lockMode = null, $lockVersion = null)
 * @method Guest|null findOneBy(array $criteria, array $orderBy = null)
 * @method Guest[]    findAll()
 * @method Guest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Guest::class);
    }

    public function getGuestAssignedToUser($userId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM guest
        WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $userId]);


        return $resultSet->fetchAllAssociative();
    }


    public function getSummaryOfGuest($userId)
    {

        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT COUNT(name) AS numberOfGuest, 
        (SELECT COUNT(is_confirmed) FROM guest WHERE  user_id = :user_id and is_confirmed = 1) as confirmed,
        (SELECT COUNT(is_accommodation) FROM guest WHERE  user_id = :user_id and is_accommodation = 1) as accommodation,
        (SELECT COUNT(transport) FROM guest WHERE  user_id = :user_id and transport = 1) as transport,
        (SELECT COUNT(is_adult) FROM guest WHERE  user_id = :user_id and is_adult = 1) as adult,
        (SELECT COUNT(is_child_under_three_years) FROM guest WHERE  user_id = :user_id and is_child_under_three_years = 1) as childUnderThree,
        (SELECT COUNT(is_child_between_three_and_twelve) FROM guest WHERE  user_id = :user_id and is_child_between_three_and_twelve = 1) as childOverThree,
        (SELECT COUNT(special_diet) FROM guest WHERE  user_id = :user_id and special_diet = 1) as Diet
        FROM guest
        WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $userId]);


        return $resultSet->fetchAllAssociative();
    }

    //    /**
    //     * @return Guest[] Returns an array of Guest objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Guest
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
