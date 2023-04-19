<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function save(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByFilters($searchTerm = null, array $categoryFilters = [], array $priceFilters = [], array $orderBy = null, $limit = null, $offset = null): array
    {
        $queryBuilder = $this->createQueryBuilder('p');

        // Apply search term filter
        if (!empty($searchTerm)) {
            $queryBuilder
                ->andWhere('p.nom LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        // Apply category filters
        if (!empty($categoryFilters)) {
            $queryBuilder
                ->andWhere('p.categorie IN (:categories)')
                ->setParameter('categories', $categoryFilters);
        }

        // Apply price filters
        if (!empty($priceFilters)) {
            $priceRangeFilters = [];
            foreach ($priceFilters as $priceFilter) {
                switch ($priceFilter) {
                    case 'price1':
                        $priceRangeFilters[] = [
                            'min' => 0,
                            'max' => 5,
                        ];
                        break;
                    case 'price2':
                        $priceRangeFilters[] = [
                            'min' => 5,
                            'max' => 15,
                        ];
                        break;
                    case 'price3':
                        $priceRangeFilters[] = [
                            'min' => 15,
                            'max' => null,
                        ];
                        break;
                }
            }
            if (!empty($priceRangeFilters)) {
                $orX = $queryBuilder->expr()->orX();
                foreach ($priceRangeFilters as $priceRangeFilter) {
                    if ($priceRangeFilter['max'] !== null) {
                        $orX->add(
                            $queryBuilder->expr()->andX(
                                $queryBuilder->expr()->gte('p.prix', $priceRangeFilter['min']),
                                $queryBuilder->expr()->lte('p.prix', $priceRangeFilter['max'])
                            )
                        );
                    } else {
                        $orX->add(
                            $queryBuilder->expr()->gte('p.prix', $priceRangeFilter['min'])
                        );
                    }
                }
                $queryBuilder->andWhere($orX);
            }
        }

        // Apply order by clause
        if ($orderBy !== null) {
            foreach ($orderBy as $field => $direction) {
                $queryBuilder->orderBy('p.' . $field, $direction);
            }
        }

        // Apply limit and offset clauses
        if ($limit !== null) {
            $queryBuilder->setMaxResults($limit);
        }

        if ($offset !== null) {
            $queryBuilder->setFirstResult($offset);
        }

        return $queryBuilder->getQuery()->getResult();
    }
    public function findProductsByVendeur()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('v.nom as vendeurNom, COUNT(p.idproduit) as productCount')
            ->leftJoin('p.vendeur', 'v')
            ->groupBy('v.idUser')
            ->getQuery();
    
        $result = $qb->getResult();
        $data = [];
    
        foreach ($result as $row) {
            $data[] = [$row['vendeurNom'], (int) $row['productCount']];
        }
    
        return $data;
    }

    public function findSellersByProductCount()
    {
        $qb = $this->createQueryBuilder('p')
            ->select('v.nom as vendeurNom, v.prenom as vendeurPrenom, COUNT(p.idproduit) as productCount')
            ->leftJoin('p.vendeur', 'v')
            ->groupBy('v.idUser')
            ->orderBy('productCount', 'DESC')
            ->getQuery();
    
        return $qb->getResult();
    }
//    /**
//     * @return Produit[] Returns an array of Produit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Produit
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
