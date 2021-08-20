<?php

namespace App\Repository;

use App\Entity\Ordenar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ordenar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordenar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordenar[]    findAll()
 * @method Ordenar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdenarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordenar::class);
    }

    // /**
    //  * @return Ordenar[] Returns an array of Ordenar objects
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
    public function findOneBySomeField($value): ?Ordenar
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
