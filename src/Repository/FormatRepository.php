<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\Format;
use App\Entity\User;
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
     * @param array<mixed> $value
     */
    public function findByFormatChoices(array $value): array
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
    public function findFormatsByBasketId(int $value): ArrayCollection
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

    public function findOneByBookId(Book $book): ?Format
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.id = :val')
            ->setParameter('val', $book)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
    * @return Format[] Returns an array of Format objects
    */
    public function findByOrderStatus(User $customer): array
    {
        return $this->createQueryBuilder('f')
            ->join('f.book', 'b')
            ->join('f.baskets', 'c')
            ->join('c.orderId', 'o')
            ->join('o.status', 'os')
            ->andWhere('os.status = :statusOrder')
            ->andWhere('c.status = :statusBasket')
            ->andWhere('c.customer = :val')
            ->setParameter('val', $customer)
            ->setParameter('statusOrder', 'Paiement accepté')
            ->setParameter('statusBasket', 'Transformé')
            ->orderBy('c.createdAt', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return float
     */
    public function findAverageRatingForFormat(Format $format)
    {
        return $this->createQueryBuilder('f')
            ->select('AVG(fb.stars) as averageRating')
            ->leftJoin('f.feedbacks', 'fb')
            ->where('f = :format')
            ->setParameter('format', $format)
            ->getQuery()
            ->getSingleScalarResult();
    }

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
