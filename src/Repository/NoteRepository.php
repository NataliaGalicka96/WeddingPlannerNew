<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Note>
 *
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    public function remove(Note $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getNoteAssignedToUser($userId)
    {

        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM note
        WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['user_id' => $userId]);


        return $resultSet->fetchAllAssociative();
    }

    public function updateTitle($userId, $id, $title)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE note
        SET title = :title
        WHERE user_id = :user_id AND id =:id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'user_id' => $userId,
            'title' => $title,
            'id' => $id
        ]);


        return $resultSet->fetchAllAssociative();
    }

    public function updateNote($userId, $id, $note)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "UPDATE note
        SET note = :note
        WHERE user_id = :user_id AND id =:id";

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'user_id' => $userId,
            'note' => $note,
            'id' => $id
        ]);


        return $resultSet->fetchAllAssociative();
    }


    //    /**
    //     * @return Note[] Returns an array of Note objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Note
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
