<?php

namespace App\Repository;

use App\Entity\CategoriaSecundaria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\UserBusqueda;


/**
 * @method CategoriaSecundaria|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriaSecundaria|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriaSecundaria[]    findAll()
 * @method CategoriaSecundaria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriaSecundariaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriaSecundaria::class);
    }

   

    public function buscarPorFecha(){

    }

    public function buscarPorPublicado(){
        
    }

    public function buscarTodos(){

    }

}
