<?php

namespace App\Repository;

use App\Entity\BoSkCo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BoSkCo>
 */
class BoSkCoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoSkCo::class);
    } 
 
    /**
    * @return array Returns an array of Contributors id
    */
    public function FindContributorByBookId($value): array
    {
        return $this->createQueryBuilder('bsc')
            ->select('c.id AS contributorsId')
            ->join('bsc.contributor', 'c')
            ->join('bsc.book', 'b')
            ->join('bsc.skill', 's')
            ->andWhere('b.id = :val')
            ->andWhere('s.name = :skillName')
            ->setParameter('skillName', 'Auteur')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//     public function FindByAuthorId(array $value): array
//     {
//         return $this->createQueryBuilder('bsc')
//             ->innerJoin('bsc.contributor', 'c')
//             ->innerJoin('bsc.skill', 's')
//             ->innerJoin('bsc.book', 'b')
//             ->andWhere('c.id IN (:val)')
//             ->setParameter('val', $value)
//             ->orderBy('b.id', 'ASC')
//             ->setMaxResults(12)
//             ->getQuery()
//             ->getResult()
//         ;
//     }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//     public function findByDate(): array
//     {
//         return $this->createQueryBuilder('bsc')
//             ->innerJoin('bsc.contributor', 'c')
//             ->innerJoin('bsc.skill', 's')
//             ->innerJoin('bsc.book', 'b')
//             ->andWhere('b.parutionDate > b.creationDate')
//             ->andWhere('s.name = :skillName')
//             ->setParameter('skillName', 'Auteur')
//             ->orderBy('bsc.id', 'DESC')
//             ->setMaxResults(10)
//             ->getQuery()
//             ->getResult()
//         ;
//     }
//       /**
//     * @return BoSkCo[] Returns an array of Book objects
//     */
//    public function findByDate(): array
//    {
//        return $this->createQueryBuilder('bsc')
//            ->join('bsc.book', 'b')
//            ->join('bsc.skill', 's')
//            ->join('bsc.contributor', 'c')
//            ->andWhere('b.parutionDate > b.creationDate')
//            ->andWhere('s.name = :skillName')
//            ->setParameter('skillName', 'Auteur')
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    /**
//     * @return BoSkCo[] Returns an array of BoSkCo objects
//     */
//    public function FindByBookId($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->join('b.skill', 's')
//            ->join('b.book', 'bk')
//            ->join('b.contributor', 'c')
//            ->andWhere('bk.id = :val')
//            ->andWhere('s.name = :skillName')
//            ->setParameter('val', $value)
//            ->setParameter('skillName', 'Auteur')
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(12)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    /**
//     * @return BoSkCo[] Returns an array of BoSkCo objects
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

//    public function findOneBySomeField($value): ?BoSkCo
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
