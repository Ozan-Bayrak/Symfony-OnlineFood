<?php

namespace App\Repository\Admin;

use App\Entity\Admin\OrderDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OrderDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDetails[]    findAll()
 * @method OrderDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDetails::class);
    }

    // /**
    //  * @return OrderDetails[] Returns an array of OrderDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderDetails
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getUserOrders($id): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql='
                SELECT o.*,f.title as fname, r.title as oname  FROM order_details o 
                JOIN food f ON f.id = o.foodid
                JOIN orders r ON r.id = o.ordersid
                WHERE o.userid = :userid
                ORDER BY o.id DESC ';
        $stmt =$conn->prepare($sql);
        $stmt->execute(['userid'=>$id]);

        return $stmt->fetchAll();

    }
    public function getUserOrderss($status): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql='
                SELECT o.*,f.title as fname, r.title as oname, usr.name as uname FROM order_details o 
                JOIN food f ON f.id = o.foodid
                JOIN orders r ON r.id = o.ordersid
                JOIN user usr ON usr.id = o.userid
                WHERE o.status =:status
                ';
        $stmt =$conn->prepare($sql);
        $stmt->execute(['status'=>$status]);

        return $stmt->fetchAll();

    }
}
