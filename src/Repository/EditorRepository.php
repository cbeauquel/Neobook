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
        ->orderBy('e.id', 'DESC');

        // Adapter pour Pagerfanta
        $adapter = new QueryAdapter($queryBuilder);

        // Créer un objet Pagerfanta
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($limit);
        $pagerfanta->setCurrentPage($page);

        return $pagerfanta;
    }

    /**
    * @return int return number of books for an editor
    */
    public function countByEditor(int $id): int
    {
        return $this->createQueryBuilder('e')
            ->select('COUNT(b.id)')
            ->join('e.books', 'b')
            ->andWhere('e.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    /**
    * @return string Returns the ID of the last Editor (test admineditor)
    */
    public function findLastEditorId(): string
    {
        return $this->createQueryBuilder('e')
            ->select('MAX(e.id)')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getSingleScalarResult();
        ;
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
