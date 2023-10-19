<?php

namespace App\Repository;

use App\Entity\ImageProduit;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends EntityRepository
{
    /*public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }
    */

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

public function findListProduit(): array
{
  
    $qb=$this->createQueryBuilder('p');

    $qb ->select('p.id','p.nom','p.description','p.prix','im.path as image')
        ->innerJoin(ImageProduit::class,'im')
        ->where('p.id = im.produit');
        

    return $qb->getQuery()->getArrayResult();

}

public function findOneProduit(int $id): array
{
  
    $qb=$this->createQueryBuilder('p');

    $qb ->select('p.id','p.nom','p.description','p.prix','im.path as image')
        ->innerJoin(ImageProduit::class,'im')
        ->where('p.id = im.produit')
        ->andWhere('im.produit = :idProduit')
        ->setParameter('idProduit', $id);
        
        

    return $qb->getQuery()->getArrayResult();

}

public function findLastProduit(): array
{
  
    $qb=$this->createQueryBuilder('p');

    $qb 
        ->orderBy('p.id', 'DESC')
        ->setMaxResults(1);
        
        

    return $qb->getQuery()->getArrayResult();

}

}
