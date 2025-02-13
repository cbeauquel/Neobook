<?php

namespace App\Repository;

use App\Entity\ToBeRead;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ToBeRead>
 */
class ToBeReadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ToBeRead::class);
    }

      /**
        * @return ToBeRead[] Returns an array of ToBeRead objects
        */
       public function findByCustomerId($value): array
       {
           return $this->createQueryBuilder('t')
               ->innerJoin('t.book', 'b')
               ->innerJoin('b.boSkCos', 'bsc')
               ->innerJoin('bsc.skill', 's')
               ->innerJoin('bsc.contributor', 'c')
               ->addSelect('b')
               ->andWhere('t.customer = :val')
               ->setParameter('val', $value)
               ->orderBy('t.id', 'ASC')
               ->setMaxResults(10)
               ->getQuery()
               ->getResult()
           ;
       }

    //    /**
    //     * @return ToBeRead[] Returns an array of ToBeRead objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ToBeRead
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
