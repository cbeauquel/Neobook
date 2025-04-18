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
        ->orderBy('c.id', 'ASC');

        // Adapter pour Pagerfanta
        $adapter = new QueryAdapter($queryBuilder);

        // Créer un objet Pagerfanta
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($limit);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
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
