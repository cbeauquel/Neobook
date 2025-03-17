<?php

namespace App\Repository;

use App\Entity\Book;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

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
            ->addSelect('bsc')
            ->addSelect('s')
            ->addSelect('c')
            ->andWhere('b.parutionDate > :today')
            ->andWhere('b.status = :value')
            ->andWhere('s.name = :skillName')
            ->setParameter('skillName', 'Auteur')
            ->setParameter('today', $today)
            ->setParameter('value', '1')
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Book[] Returns an array of Book objects
     */
    public function findNew(): array
    {
        $today = new \DateTime(); // Obtenir la date du jour (sans heure si nécessaire)
        $twentyDaysAgo = new DateTimeImmutable('-20 days'); //tous les livres qui ont une date de création de moins de 20jours
        return $this->createQueryBuilder('b')
            ->innerJoin('b.boSkCos', 'bsc')
            ->innerJoin('bsc.skill', 's')
            ->innerJoin('bsc.contributor', 'c')
            ->addSelect('bsc')
            ->addSelect('s')
            ->addSelect('c')
            ->andWhere('b.createdAt <= :today')
            ->andWhere('b.createdAt >= :date')
            ->andWhere('b.status = :value')
            ->andWhere('s.name = :skillName')
            ->setParameter('skillName', 'Auteur')
            ->setParameter('date', $twentyDaysAgo)
            ->setParameter('today', $today)
            ->setParameter('value', '1')
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult()
        ;
    }
 
    /**
    * @return Book[] Returns an array of Book objects
    * @param array<mixed> $value
    */
    public function findByAuthorId(array $value): array
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.boSkCos', 'bsc')
            ->innerJoin('bsc.contributor', 'c')
            ->innerJoin('bsc.skill', 's')
            ->addSelect('bsc')
            ->addSelect('s')
            ->addSelect('c')
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
    * @param int $value
    */
    public function findByEditorId(int $value): array
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.boSkCos', 'bsc')
            ->innerJoin('bsc.contributor', 'c')
            ->innerJoin('bsc.skill', 's')
            ->innerJoin('b.editor', 'e')
            ->addSelect('bsc')
            ->addSelect('c')
            ->addSelect('s')
            ->addSelect('e')
            ->andWhere('e.id IN (:val)')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Pagerfanta Returns an array of Book objects
     */
    public function findPaginatedBooks(int $page, int $limit): Pagerfanta
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->orderBy('b.id', 'ASC');

        // Adapter pour Pagerfanta
        $adapter = new QueryAdapter($queryBuilder);

        // Créer un objet Pagerfanta
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($limit);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
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
