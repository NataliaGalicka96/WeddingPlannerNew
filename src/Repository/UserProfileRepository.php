<?php

namespace App\Repository;

use App\Entity\UserProfile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserProfile>
 *
 * @method UserProfile|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProfile|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProfile[]    findAll()
 * @method UserProfile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProfile::class);
    }

    public function getDataOfWedding($userId)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT *, COALESCE(budget,0) AS budget FROM user_profile
        WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $userId]);


        return $resultSet->fetchAllAssociative();
    }

    public function setUserBudget($userId, $budget)
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE user_profile
        SET budget = :budget
        WHERE user_id =:userId";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'userId' => $userId,
            'budget' => $budget
        ]);


        return $resultSet->fetchAllAssociative();
    }


    public function check_user_profile($userId)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT CASE WHEN COUNT(*)=1 THEN 1 ELSE 0 END AS profile_exists FROM user_profile
        WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $userId]);

        $result = $resultSet->fetchAllAssociative();

        return $result[0]['profile_exists'];
    }

    public function addBudget($userId, $budget)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO user_profile (budget, user_id)
        VALUES (:budget, :user_id)";


        $stmt = $conn->prepare($sql);

        $resultSet = $stmt->executeQuery([
            'user_id' => $userId,
            'budget' => $budget
        ]);


        return $resultSet->fetchAllAssociative();
    }


    //    /**
    //     * @return UserProfile[] Returns an array of UserProfile objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?UserProfile
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
