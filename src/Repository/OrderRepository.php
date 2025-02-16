<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

        /**
         * @return Bool true si au moins une order avec l'id du customer fourni
        */
        public function findByUserId(User $customer): bool
        {
            return (bool) $this->createQueryBuilder('o')
                ->select('COUNT(o.id)')
                ->where('o.customer = :customer')
                ->setParameter('customer', $customer)
                ->getQuery()
                ->getSingleScalarResult();
        }

        /**
         * @return Order au moins une order avec l'id du basket fourni
        */
        public function findByBasketId($value): ?Order
        {
            return $this->createQueryBuilder('o')
                ->andWhere('o.basket = :val')
                ->join('o.basket', 'b')
                ->join('b.formats', 'f')
                ->addSelect('b')
                ->addSelect('f')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }


       /**
        * @return Order[] Returns an array of Order objects
        */
       public function findByCustomerId($value): array
       {
           return $this->createQueryBuilder('o')
               ->andWhere('o.customer = :val')
               ->setParameter('val', $value)
               ->orderBy('o.id', 'ASC')
               ->setMaxResults(10)
               ->getQuery()
               ->getResult()
           ;
       }

    //    /**
    //     * @return Order[] Returns an array of Order objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Order
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
