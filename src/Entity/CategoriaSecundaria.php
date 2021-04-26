<?php

namespace App\Entity;

use App\Repository\CategoriaSecundariaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=CategoriaSecundariaRepository::class)
 */
class CategoriaSecundaria
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre_categoria;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion_categoria;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icono;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $publicado;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_publicacion_desde;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_publicacion_hasta;

    /**
     * @ORM\ManyToOne(targetEntity=CategoriaPrincipal::class, inversedBy="categoriaSecundaria")
     * 
     */
    private $id_categoria_principal;

    /**
     * @ORM\OneToMany(targetEntity=Informacion::class, mappedBy="id_categoria_secundaria", cascade={"remove"})
     */
    private $informacion;

    /**
     * @ORM\Column(type="integer",  nullable=true)
     */
    private $click;

    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    private $infoAsignada;

    /**
     * @ORM\OneToOne(targetEntity=Informacion::class, mappedBy="catSecundaria", cascade={"persist", "remove"})
     */
    private $informacionOne;



   
    public function __construct()
    {
        $this ->icono = null;
        $this->informacion = new ArrayCollection();
  
     
   
    }    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreCategoria(): ?string
    {
        return $this->nombre_categoria;
    }

    public function setNombreCategoria(string $nombre_categoria): self
    {
        $this->nombre_categoria = $nombre_categoria;

        return $this;
    }

    public function getDescripcionCategoria(): ?string
    {
        return $this->descripcion_categoria;
    }

    public function setDescripcionCategoria(string $descripcion_categoria): self
    {
        $this->descripcion_categoria = $descripcion_categoria;

        return $this;
    }

    public function getIcono()
    {
        return $this->icono;
    }

    public function setIcono($icono): self
    {
        $this->icono = $icono;

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

    public function getIdCategoriaPrincipal(): ?CategoriaPrincipal
    {
        return $this->id_categoria_principal;
    }

    public function setIdCategoriaPrincipal(?CategoriaPrincipal $id_categoria_principal): self
    {
        $this->id_categoria_principal = $id_categoria_principal;

        return $this;
    }

    /**
     * @return Collection|Informacion[]
     */
    public function getInformacion(): Collection
    {
        return $this->informacion;
    }

    public function addInformacion(Informacion $informacion): self
    {
        if (!$this->informacion->contains($informacion)) {
            $this->informacion[] = $informacion;
            $informacion->setIdCategoriaSecundaria($this);
        }

        return $this;
    }

    public function removeInformacion(Informacion $informacion): self
    {
        if ($this->informacion->removeElement($informacion)) {
            // set the owning side to null (unless already changed)
            if ($informacion->getIdCategoriaSecundaria() === $this) {
                $informacion->setIdCategoriaSecundaria(null);
            }
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

    public function getInfoAsignada(): ?bool
    {
        return $this->infoAsignada;
    }

    public function setInfoAsignada(bool $infoAsignada): self
    {
        $this->infoAsignada = $infoAsignada;

        return $this;
    }

    public function getInformacionOne(): ?Informacion
    {
        return $this->informacionOne;
    }

    public function setInformacionOne(?Informacion $informacionOne): self
    {
        // unset the owning side of the relation if necessary
        if ($informacionOne === null && $this->informacionOne !== null) {
            $this->informacionOne->setCatSecundaria(null);
        }

        // set the owning side of the relation if necessary
        if ($informacionOne !== null && $informacionOne->getCatSecundaria() !== $this) {
            $informacionOne->setCatSecundaria($this);
        }

        $this->informacionOne = $informacionOne;

        return $this;
    }

 

    
    



    
 
}
