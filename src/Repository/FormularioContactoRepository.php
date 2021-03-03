<?php

namespace App\Repository;

use App\Entity\FormularioContacto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormularioContacto|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormularioContacto|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormularioContacto[]    findAll()
 * @method FormularioContacto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormularioContactoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormularioContacto::class);
    }

    // /**
    //  * @return FormularioContacto[] Returns an array of FormularioContacto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormularioContacto
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
