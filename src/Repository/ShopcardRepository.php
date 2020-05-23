<?php

namespace App\Repository;

use App\Entity\Shopcard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Shopcard|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shopcard|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shopcard[]    findAll()
 * @method Shopcard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShopcardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shopcard::class);
    }

    // /**
    //  * @return Shopcard[] Returns an array of Shopcard objects
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
    public function findOneBySomeField($value): ?Shopcard
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getShopcard($userid): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql='
                SELECT o.title as food , f.title as rname, o.price , s.quantity, (o.price * s.quantity) as total, s.* 
                FROM food f, shopcard s, orders o
                WHERE s.ordersid = o.id and o.foodid = f.id and s.userid=:userid
                ';
        $stmt =$conn->prepare($sql);
        $stmt->execute(['userid'=>$userid]);

        return $stmt->fetchAll();

    }
    public function getUserShopCartTotal($userid):float {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT sum(o.price * s.quantity) AS total FROM App\Entity\Shopcard s, App\Entity\Admin\Orders o
                WHERE s.ordersid = o.id AND s.userid=:userid')
            ->setParameter('userid',$userid);
        $result = $query->getResult();

        if ($result[0]["total"] != null){
            return $result[0]["total"];
        }
        else{
            return 0;
        }
    }
}
