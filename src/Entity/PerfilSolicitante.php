<?php

namespace App\Entity;

use App\Repository\PerfilSolicitanteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PerfilSolicitanteRepository::class)
 */
class PerfilSolicitante
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
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion_larga;

     /**
     * @ORM\Column(type="string", length=15)
     */
    private $publicado;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $comunidad_unraf;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_publicacion_desde;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_publicacion_hasta;

    /**
     * @ORM\ManyToMany(targetEntity=CategoriaPrincipal::class, mappedBy="perfilSolicitante")
     */
    private $id_categoria_principal;

    /**
     * @ORM\Column(type="integer",  nullable=true)
     */
    private $click;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icono;

  

    

    public function __construct()
    {
        $this->id_categoria_principal = new ArrayCollection();
        $this ->icono = null;
       
      
        
    }

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

    public function getDescripcionLarga(): ?string
    {
        return $this->descripcion_larga;
    }

    public function setDescripcionLarga(string $descripcion_larga): self
    {
        $this->descripcion_larga = $descripcion_larga;

        return $this;
    }


    public function getPublicado(): ?string
    {
        return $this->publicado;
    }

    public function setPublicado(string $publicado): self
    {
        $this->publicado = $publicado;

        return $this;
    }

    public function getComunidadUnraf(): ?string
    {
        return $this->comunidad_unraf;
    }

    public function setComunidadUnraf(string $comunidad_unraf): self
    {
        $this->comunidad_unraf = $comunidad_unraf;

        return $this;
    }

    public function getFechaPublicacionDesde(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion_desde;
    }

    public function setFechaPublicacionDesde(?\DateTimeInterface $fecha_publicacion_desde): self
    {
        $this->fecha_publicacion_desde = $fecha_publicacion_desde;

        return $this;
    }

    public function getFechaPublicacionHasta(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion_hasta;
    }

    public function setFechaPublicacionHasta(?\DateTimeInterface $fecha_publicacion_hasta): self
    {
        $this->fecha_publicacion_hasta = $fecha_publicacion_hasta;

        return $this;
    }

    /**
     * @return Collection|CategoriaPrincipal[]
     */
    public function getIdCategoriaPrincipal(): Collection
    {
        return $this->id_categoria_principal;
    }

    public function addIdCategoriaPrincipal(CategoriaPrincipal $idCategoriaPrincipal): self
    {
        if (!$this->id_categoria_principal->contains($idCategoriaPrincipal)) {
            $this->id_categoria_principal[] = $idCategoriaPrincipal;
            $idCategoriaPrincipal->addPerfilSolicitante($this);
        }

        return $this;
    }

    public function removeIdCategoriaPrincipal(CategoriaPrincipal $idCategoriaPrincipal): self
    {
        if ($this->id_categoria_principal->removeElement($idCategoriaPrincipal)) {
            $idCategoriaPrincipal->removePerfilSolicitante($this);
        }

        return $this;
    }

    public function getClick(): ?int
    {
        return $this->click;
    }

    public function setClick(int $click): self
    {
        $this->click = $click;

        return $this;
    }

    public function getIcono(): ?string
    {
        return $this->icono;
    }

    public function setIcono(?string $icono): self
    {
        $this->icono = $icono;

        return $this;
    }

    

  
}
