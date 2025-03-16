<?php

namespace App\Repository;

use App\Entity\Format;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Format>
 */
class FormatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Format::class);
    }

    /**
     * @return Format[] Returns an array of Format objects
     */
    public function findByFormatChoices($value): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.id IN (:val)')
            ->innerJoin('f.book', 'b')
            ->innerJoin('b. editor', 'e')
            ->innerJoin('f.type', 't')
            ->innerJoin('f.tvaRate', 'r')
            ->addSelect('b')
            ->addSelect('t')
            ->addSelect('r')
            ->addSelect('e')
            ->orderBy('f.id', 'ASC')
            ->setParameter('val', $value)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return ArrayCollection Returns an array of Format objects
     */
    public function findFormatsByBasketId($value): ArrayCollection
    {
        $qb = $this->createQueryBuilder('f')
           ->andWhere('b.id = :val')
           ->join('f.baskets', 'b')
           ->setParameter('val', $value)
           ->addSelect('bo')
           ->innerJoin('f.book', 'bo')
           ->innerJoin('f.type', 't')
           ->addSelect('t')
           ->orderBy('f.id', 'ASC')
           ->setMaxResults(10)
           ->getQuery();

        $result = $qb->getResult(); // Retourne un tableau d'objets Format

        return new ArrayCollection($result); // Convertir en ArrayCollection
    }

    //    public function findOneBySomeField($value): ?Format
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    
    //    /**
    //     * @return Format[] Returns an array of Format objects
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

    //    public function findOneBySomeField($value): ?Format
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
