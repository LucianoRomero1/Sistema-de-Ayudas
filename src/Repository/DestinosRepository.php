<?php

namespace App\Repository;

use App\Entity\Destinos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Destinos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Destinos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Destinos[]    findAll()
 * @method Destinos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DestinosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Destinos::class);
    }

    // /**
    //  * @return Destinos[] Returns an array of Destinos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Destinos
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
