<?php

namespace App\Entity;

use App\Repository\ArchivosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArchivosRepository::class)
 */
class Archivos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $nombreArchivo;

    /**
     * @ORM\ManyToOne(targetEntity=Contacto::class, inversedBy="archivos", cascade={"persist"})
     */
    private $contacto;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreArchivo(): ?string
    {
        return $this->nombreArchivo;
    }

    public function setNombreArchivo(string $nombreArchivo): self
    {
        $this->nombreArchivo = $nombreArchivo;

        return $this;
    }

    public function getContacto(): ?Contacto
    {
        return $this->contacto;
    }

    public function setContacto(?Contacto $contacto): self
    {
        $this->contacto = $contacto;

        return $this;
    }

   
}
