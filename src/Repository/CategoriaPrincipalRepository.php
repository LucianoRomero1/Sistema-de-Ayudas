<?php

namespace App\Repository;

use App\Entity\CategoriaPrincipal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriaPrincipal|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriaPrincipal|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriaPrincipal[]    findAll()
 * @method CategoriaPrincipal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaPrincipalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriaPrincipal::class);
    }

    // /**
    //  * @return CategoriaPrincipal[] Returns an array of CategoriaPrincipal objects
    //  */
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
    public function findOneBySomeField($value): ?CategoriaPrincipal
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
