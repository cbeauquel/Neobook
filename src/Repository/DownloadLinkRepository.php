<?php

namespace App\Repository;

use App\Entity\DownloadLink;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DownloadLink>
 */
class DownloadLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DownloadLink::class);
    }

    /**
     * Trouve les liens actifs d'un utilisateur avec leurs relations
     * @return array<string>
     */
    public function findActiveLinksForUser(User $user): array
    {
        return $this->createQueryBuilder('dl')
            ->leftJoin('dl.format', 'f')
            ->leftJoin('f.book', 'b')
            ->leftJoin('f.type', 't')
            ->leftJoin('dl.order', 'o')
            ->addSelect('f', 'b', 't', 'o')
            ->where('dl.customer = :user')
            ->andWhere('dl.isActive = true')
            ->andWhere('dl.downloadCount < dl.maxDownloads')
            ->andWhere('dl.expiresAt IS NULL OR dl.expiresAt > :now')
            ->setParameter('user', $user)
            ->setParameter('now', new \DateTime())
            ->orderBy('dl.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les liens expirés
     * @return array<string>
     */
    public function findExpiredLinks(): array
    {
        return $this->createQueryBuilder('dl')
            ->where('dl.expiresAt < :now')
            ->andWhere('dl.isActive = true')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les liens épuisés (nombre max de téléchargements atteint)
     * @return array<string>
     */
    public function findExhaustedLinks(): array
    {
        return $this->createQueryBuilder('dl')
            ->where('dl.downloadCount >= dl.maxDownloads')
            ->andWhere('dl.isActive = true')
            ->getQuery()
            ->getResult();
    }

    /**
     * Statistiques de téléchargement par période
     * @return array<int>
     */
    public function getDownloadStatsByPeriod(\DateTime $startDate, \DateTime $endDate): array
    {
        return $this->createQueryBuilder('dl')
            ->select('
                COUNT(dl.id) as totalLinks,
                SUM(dl.downloadCount) as totalDownloads,
                AVG(dl.downloadCount) as avgDownloadsPerLink
            ')
            ->where('dl.createdAt BETWEEN :start AND :end')
            ->setParameter('start', $startDate)
            ->setParameter('end', $endDate)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * Top des livres les plus téléchargés
     * @return array<mixed>
     */
    public function getMostDownloadedBooks(int $limit = 10): array
    {
        return $this->createQueryBuilder('dl')
            ->select('
                b.id as bookId,
                b.title as bookTitle,
                SUM(dl.downloadCount) as totalDownloads,
                COUNT(DISTINCT dl.customer) as uniqueCustomers
            ')
            ->leftJoin('dl.format', 'f')
            ->leftJoin('f.book', 'b')
            ->groupBy('b.id', 'b.title')
            ->orderBy('totalDownloads', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Vérifie si un utilisateur a déjà un lien actif pour un format donné
     * @return bool
     * @param User $user
     * @param int $formatId
     */
    public function hasActiveLinkForFormat(User $user, int $formatId): bool
    {
        $result = $this->createQueryBuilder('dl')
            ->select('COUNT(dl.id)')
            ->where('dl.customer = :user')
            ->andWhere('dl.format = :formatId')
            ->andWhere('dl.isActive = true')
            ->andWhere('dl.downloadCount < dl.maxDownloads')
            ->andWhere('dl.expiresAt IS NULL OR dl.expiresAt > :now')
            ->setParameter('user', $user)
            ->setParameter('formatId', $formatId)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getSingleScalarResult();

        return $result > 0;
    }

    /**
     * Nettoie les anciens liens inactifs (pour maintenance)
     */
    public function deleteOldInactiveLinks(\DateTime $olderThan): int
    {
        return $this->createQueryBuilder('dl')
            ->delete()
            ->where('dl.isActive = false')
            ->andWhere('dl.createdAt < :date')
            ->setParameter('date', $olderThan)
            ->getQuery()
            ->execute();
    }
}
