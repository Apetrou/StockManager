<?php

namespace App\Repository;

use App\Entity\CustomerRisk;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CustomerRisk|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerRisk|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerRisk[]    findAll()
 * @method CustomerRisk[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRiskRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CustomerRisk::class);
    }

//    /**
//     * @return CustomerRisk[] Returns an array of CustomerRisk objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CustomerRisk
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
