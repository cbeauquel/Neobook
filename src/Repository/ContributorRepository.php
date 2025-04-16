<?php

namespace App\Repository;

use App\Entity\Contributor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @extends ServiceEntityRepository<Contributor>
 */
class ContributorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contributor::class);
    }


    /**
     * @return array<string> Returns an array of skills by authorId
     * @param array<mixed> $value
     */
    public function findSkillsByAuthorId(array $value): array
    {
        return $this->createQueryBuilder('c')
            ->select('DISTINCT s.name')
            ->join('c.boSkCos', 'bsc')
            ->join('bsc.skill', 's')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->orderBy('s.name', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Pagerfanta Returns an array of contributors
     */
    public function findPaginatedcontributors(int $page, int $limit): Pagerfanta
    {
        $queryBuilder = $this->createQueryBuilder('c')
        ->join('c.boSkCos', 'bo')
        ->orderBy('c.id', 'DESC');

        // Adapter pour Pagerfanta
        $adapter = new QueryAdapter($queryBuilder);

        // Créer un objet Pagerfanta
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($limit);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
    }

    /**
    * @return int return number of books for a contributor
    */
    public function countByContributor(int $id): int
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(b.id)')
            ->join('c.boSkCos', 'bo')
            ->join('bo.book', 'b')
            ->join('bo.skill', 's')
            ->andWhere('c.id = :val')
            ->andWhere('s.name = :skill')
            ->setParameter('val', $id)
            ->setParameter('skill', 'Auteur')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
    * @return string Returns the ID of the last Category (test adminCategory)
    */
    public function findLastContributorId(): string
    {
        return $this->createQueryBuilder('co')
            ->select('MAX(co.id)')
            ->orderBy('co.id', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();
        ;
    }

    //    /**
    //     * @return Contributor[] Returns an array of Contributor objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Contributor
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
