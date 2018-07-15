<?php

namespace App\Repository;

use App\Entity\CustomerCity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CustomerCity|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerCity|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerCity[]    findAll()
 * @method CustomerCity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerCityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CustomerCity::class);
    }

//    /**
//     * @return CustomerCity[] Returns an array of CustomerCity objects
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
    public function findOneBySomeField($value): ?CustomerCity
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
