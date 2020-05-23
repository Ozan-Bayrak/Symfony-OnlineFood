<?php

namespace App\Repository;

use App\Entity\ShopDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ShopDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopDetail[]    findAll()
 * @method ShopDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShopDetail::class);
    }

    // /**
    //  * @return ShopDetail[] Returns an array of ShopDetail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShopDetail
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
