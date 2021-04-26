<?php

namespace App\Entity;

class UserBusqueda
{

    private $buscar;


    public function getBuscar()
    {
        return $this->buscar;
    }

    public function setBuscar($buscar): void
    {
        $this->buscar = $buscar;

    }
}
