<?php

namespace App\Repository;

use App\Entity\CustomerArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CustomerArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerArea[]    findAll()
 * @method CustomerArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerAreaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CustomerArea::class);
    }

//    /**
//     * @return CustomerArea[] Returns an array of CustomerArea objects
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
    public function findOneBySomeField($value): ?CustomerArea
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
