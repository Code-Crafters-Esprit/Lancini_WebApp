<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offre>
 *
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }

    public function save(Offre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Offre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search(array $params): array
    {
        $qb = $this->createQueryBuilder('o');
        $or = $qb->expr()->orX();

        if (strlen($params['searchBar']) > 1 || (empty($params['secteur']) && $params['typeoffre'] === 'Choose an option') ) {
            $or->add(
                $qb->expr()->like('o.nom', ':search')
            );

            $or->add(
                $qb->expr()->like('o.competence', ':search')
            );

            $qb->setParameter('search', '%' . $params['searchBar'] . '%');
        }

        return $qb->andWhere(
            $or->add(
                $qb->expr()->andX(
                    $qb->expr()->eq('o.secteur', ':secteur'),
                    $qb->expr()->eq('o.typeoffre', ':typeoffre')
            )
            )
        )
            ->setParameter('secteur', $params['secteur'])
            ->setParameter('typeoffre', $params['typeoffre'])
            ->getQuery()
            ->getArrayResult()
        ;


        
        
    }

}