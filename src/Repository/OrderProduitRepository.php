<?php

namespace App\Repository;

use App\Entity\OrderProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderProduit>
 *
 * @method OrderProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderProduit[]    findAll()
 * @method OrderProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderProduit::class);
    }

//    /**
//     * @return OrderProduit[] Returns an array of OrderProduit objects
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

//    public function findOneBySomeField($value): ?OrderProduit
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
