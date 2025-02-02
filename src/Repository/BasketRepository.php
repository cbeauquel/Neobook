<?php

namespace App\Repository;

use App\Entity\Basket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Basket>
 */
class BasketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Basket::class);
    }
        /**
         * @return Basket
         */
       public function findBasketByCustomerOrUserToken(?object $customer, ?string $userToken): ?Basket
       {
           return $this->createQueryBuilder('b')
               ->Where('b.customer = :customer')
               ->orWhere('b.userToken = :userToken')
               ->setParameter('customer', $customer)
               ->setParameter('userToken', $userToken)
               ->andWhere('b. status = :status' )
               ->setParameter('status', 'En cours')
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }

        // /**
        //  * @return Basket
        //  */
        // public function findBasketByUserToken($value): ?Basket
        // {
        //     return $this->createQueryBuilder('b')
        //         ->andWhere('b.userToken = :val')
        //         ->setParameter('val', $value)
        //         ->andWhere('b. status = :status' )
        //         ->setParameter('status', 'En cours')
        //         ->getQuery()
        //         ->getOneOrNullResult()
        //     ;
        // }
 
    //    /**
    //     * @return Basket[] Returns an array of Basket objects
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

    //    public function findOneBySomeField($value): ?Basket
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
