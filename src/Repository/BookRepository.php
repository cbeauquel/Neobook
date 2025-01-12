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
    $today = new \DateTime(); // Obtenir la date du jour (sans heure si nécessaire)
       return $this->createQueryBuilder('b')
           ->innerJoin('b.boSkCos', 'bsc')
           ->innerJoin('bsc.skill', 's')
           ->innerJoin('bsc.contributor', 'c')
           ->andWhere('b.parutionDate > :today')
           ->andWhere('s.name = :skillName')
           ->setParameter('skillName', 'Auteur')
           ->setParameter('today', $today)
           ->orderBy('b.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

    /**
    * @return Book[] Returns an array of Book objects
    */
    public function findByAuthorId(array $value): array
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.boSkCos', 'bsc')
            ->innerJoin('bsc.contributor', 'c')
            ->innerJoin('bsc.skill', 's')
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
    * @return Book[] Returns an array of Book objects
    */
    public function findByEditorId($value): array
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.boSkCos', 'bsc')
            ->innerJoin('bsc.contributor', 'c')
            ->innerJoin('bsc.skill', 's')
            ->innerJoin('b.editor', 'e')
            ->andWhere('e.id IN (:val)')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(12)
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
