<?php

namespace App\Repository;

use App\Entity\Editor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @extends ServiceEntityRepository<Editor>
 */
class EditorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Editor::class);
    }

    /**
     * @return Pagerfanta Returns an array of editors
     */
    public function findPaginatedEditors(int $page, int $limit): Pagerfanta
    {
        $queryBuilder = $this->createQueryBuilder('e')
        ->orderBy('e.id', 'ASC');

        // Adapter pour Pagerfanta
        $adapter = new QueryAdapter($queryBuilder);

        // Créer un objet Pagerfanta
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($limit);
        $pagerfanta->setCurrentPage($page);
        
        return $pagerfanta;
    }

    //    /**
    //     * @return Editor[] Returns an array of Editor objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Editor
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
