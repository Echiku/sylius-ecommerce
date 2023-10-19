<?php

namespace App\Repository;

use App\Entity\CustomPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomPayment>
 *
 * @method CustomPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomPayment[]    findAll()
 * @method CustomPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomPayment::class);
    }

//    /**
//     * @return CustomPayment[] Returns an array of CustomPayment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CustomPayment
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
