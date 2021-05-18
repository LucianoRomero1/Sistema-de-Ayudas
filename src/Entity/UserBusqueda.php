<?php

namespace App\Entity;

class UserBusqueda
{

    private $buscar;
    private $filtrarPor;


     function getBuscar()
    {
        return $this->buscar;
    }

     function setBuscar($buscar): void
    {
        $this->buscar = $buscar;

    }

    
    function getFiltrarPor()
    {
        return $this->filtrarPor;
    }

     function setFiltrarPor($filtrarPor): void
    {
        $this->filtrarPor = $filtrarPor;

    }


}
