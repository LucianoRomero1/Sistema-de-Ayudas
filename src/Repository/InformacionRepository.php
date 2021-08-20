<?php

namespace App\Repository;

use App\Entity\Informacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Informacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Informacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Informacion[]    findAll()
 * @method Informacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InformacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Informacion::class);
    }

    // /**
    //  * @return Informacion[] Returns an array of Informacion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Informacion
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
