<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

   /**
    * @return Book[] Returns an array of Book objects
    */
   public function findByDate(): array
   {
       return $this->createQueryBuilder('b')
           ->andWhere('b.parutionDate > b.creationDate')
           ->orderBy('b.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findByAuthors(array $value): array
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.contributors', 'c')
            ->innerJoin('c.skill', 's')
            ->andWhere('c.id IN (:val)')
            ->andWhere('s.name = :skillName')
            ->setParameter('val', $value)
            ->setParameter('skillName', 'Auteur')
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult()
        ;
    }

   /**
    * @return array Returns an array of Contributors id
    */
   public function FindByBookId($value): array
   {
       return $this->createQueryBuilder('a')
           ->select('c.id AS contributorsId')
           ->join('a.contributors', 'c')
           ->andWhere('a.id = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getResult()
       ;
   }

//    /**
//     * @return Book[] Returns an array of Book objects
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

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
