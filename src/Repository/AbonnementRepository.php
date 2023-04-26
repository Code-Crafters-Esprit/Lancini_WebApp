<?php

namespace App\Repository;

use App\Entity\Abonnement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Abonnement>
 *
 * @method Abonnement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Abonnement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Abonnement[]    findAll()
 * @method Abonnement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonnementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Abonnement::class);
    }

    public function save(Abonnement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Abonnement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function find3ByUserId($value): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.userid = :val')
            ->setParameter('val', $value)
            ->orderBy('a.userid', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
    public function getNumberOfFollowers(int $userId): int
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->select('COUNT(a.idAbonnement)')
            ->where('a.useridFollowed = :userId')
            ->setParameter('userId', $userId);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function isFollower(int $u1id, int $u2id): bool
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->select('COUNT(a.userid)')
            ->where('a.useridFollowed = :u1id')
            ->andWhere('a.userid = :u2id')
            ->setParameters([
                'u1id' => $u1id,
                'u2id' => $u2id,
            ]);

        return ($queryBuilder->getQuery()->getSingleScalarResult() > 0);
    }

    public function removeFollower(int $u1id, int $u2id): void
    {
        $entityManager = $this->getEntityManager();
        $abonnement = $entityManager->getRepository(Abonnement::class)->findOneBy([
            'useridFollowed' => $u1id,
            'userid' => $u2id,
        ]);

        if ($abonnement) {
            $entityManager->remove($abonnement);
            $entityManager->flush();
        }
    }

    //    /**
    //     * @return Abonnement[] Returns an array of Abonnement objects
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

    //    public function findOneBySomeField($value): ?Abonnement
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
