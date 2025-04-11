<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Feedback;
use App\Entity\Format;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Feedback>
 */
class FeedbackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feedback::class);
    }

    /**
     * @return Feedback Return a Feedback object
     */
    public function findByUserAndFormatId(Format $format, User $customer): ?Feedback
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.format = :val')
            ->andWhere('f.nickName = :user')
            ->setParameter('val', $format)
            ->setParameter('user', $customer)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
    * @return Feedback[] Return an Array of Feedbacks
    */
    public function findMyComments(User $user): array
    {
        return $this->createQueryBuilder('fb')
            ->andWhere('fb.nickName = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Feedback[] Return an Array of Feedbacks
     */
    public function findByFormatId(Format $format): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.format = :val')
            ->setParameter('val', $format)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Feedback[] Return an Array of Feedbacks
     */
    public function findByBookId(string $book): array
    {
        return $this->createQueryBuilder('fb')
            ->join('fb.format', 'f')
            ->join('f.book', 'b')
            ->andWhere('b.id = :val')
            ->setParameter('val', $book)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return float
     */
    public function findAverageStarsByBookId(string $id)
    {
        $qb = $this->createQueryBuilder('f');
    
        $qb->select('AVG(f.stars) as averageStars')
           ->join('f.format', 'fo')
           ->join('fo.book', 'b')
           ->where('b.id = :val')
           ->setParameter('val', $id);
    
        $query = $qb->getQuery();
        $result = $query->getSingleScalarResult();
    
        return $result;
    }

    //    /**
    //     * @return Feedback[] Returns an array of Feedback objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Feedback
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
