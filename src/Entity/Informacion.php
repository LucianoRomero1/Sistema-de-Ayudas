<?php

namespace App\Entity;

use App\Repository\InformacionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InformacionRepository::class)
 */
class Informacion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

      /**
     * @ORM\Column(type="string", length=150)
     */
    private $descripcion_corta;

    /**
     * @ORM\Column(type="text")
     */
    private $explicacion;




    /**
     * @ORM\ManyToOne(targetEntity=CategoriaSecundaria::class, inversedBy="informacion")
     */
    private $id_categoria_secundaria;

    /**
     * @ORM\OneToOne(targetEntity=CategoriaSecundaria::class, inversedBy="informacionOne", cascade={"persist", "remove"})
     */
    private $catSecundaria;

 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcionCorta(): ?string
    {
        return $this->descripcion_corta;
    }

    public function setDescripcionCorta(string $descripcion_corta): self
    {
        $this->descripcion_corta = $descripcion_corta;

        return $this;
    }

    public function getExplicacion(): ?string
    {
        return $this->explicacion;
    }

    public function setExplicacion(string $explicacion): self
    {
        $this->explicacion = $explicacion;

        return $this;
    }



    public function getIdCategoriaSecundaria(): ?CategoriaSecundaria
    {
        return $this->id_categoria_secundaria;
    }

    public function setIdCategoriaSecundaria(?CategoriaSecundaria $id_categoria_secundaria): self
    {
        $this->id_categoria_secundaria = $id_categoria_secundaria;

        return $this;
    }

    public function getCatSecundaria(): ?CategoriaSecundaria
    {
        return $this->catSecundaria;
    }

    public function setCatSecundaria(?CategoriaSecundaria $catSecundaria): self
    {
        $this->catSecundaria = $catSecundaria;

        return $this;
    }

   
}
