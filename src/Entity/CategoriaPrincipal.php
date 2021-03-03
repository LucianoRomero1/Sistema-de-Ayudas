<?php

namespace App\Entity;

use App\Repository\CategoriaPrincipalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriaPrincipalRepository::class)
 */
class CategoriaPrincipal
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
     * @ORM\ManyToMany(targetEntity=PerfilSolicitante::class, inversedBy="id_categoria_principal")
     */
    private $perfilSolicitante;

    /**
     * @ORM\OneToMany(targetEntity=CategoriaSecundaria::class, mappedBy="id_categoria_principal",  cascade={"remove"})
     */
    private $categoriaSecundaria;

    /**
     * @ORM\Column(type="integer",  nullable=true)
     */
    private $click;

    /**
     * @ORM\ManyToOne(targetEntity=Destinos::class, inversedBy="categoriaPP")
     */
    private $destinos;

    /**
     * @ORM\Column(type="boolean", nullable = true)
     */
    private $emailAsignado;

    public function __construct()
    {
        $this->perfilSolicitante = new ArrayCollection();
        $this->categoriaSecundaria = new ArrayCollection();
        $this ->icono = null;
       
        
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




    /**
     * @return Collection|PerfilSolicitante[]
     */
    public function getPerfilSolicitante(): Collection
    {
        return $this->perfilSolicitante;
    }

    public function addPerfilSolicitante(PerfilSolicitante $perfilSolicitante): self
    {
        if (!$this->perfilSolicitante->contains($perfilSolicitante)) {
            $this->perfilSolicitante[] = $perfilSolicitante;
        }

        return $this;
    }

    public function removePerfilSolicitante(PerfilSolicitante $perfilSolicitante): self
    {
        $this->perfilSolicitante->removeElement($perfilSolicitante);

        return $this;
    }

    /**
     * @return Collection|CategoriaSecundaria[]
     */
    public function getCategoriaSecundaria(): Collection
    {
        return $this->categoriaSecundaria;
    }

    public function addCategoriaSecundarium(CategoriaSecundaria $categoriaSecundarium): self
    {
        if (!$this->categoriaSecundaria->contains($categoriaSecundarium)) {
            $this->categoriaSecundaria[] = $categoriaSecundarium;
            $categoriaSecundarium->setIdCategoriaPrincipal($this);
        }

        return $this;
    }

    public function removeCategoriaSecundarium(CategoriaSecundaria $categoriaSecundarium): self
    {
        if ($this->categoriaSecundaria->removeElement($categoriaSecundarium)) {
            // set the owning side to null (unless already changed)
            if ($categoriaSecundarium->getIdCategoriaPrincipal() === $this) {
                $categoriaSecundarium->setIdCategoriaPrincipal(null);
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

    public function getDestinos(): ?Destinos
    {
        return $this->destinos;
    }

    public function setDestinos(?Destinos $destinos): self
    {
        $this->destinos = $destinos;

        return $this;
    }

    public function getEmailAsignado(): ?bool
    {
        return $this->emailAsignado;
    }

    public function setEmailAsignado(bool $emailAsignado): self
    {
        $this->emailAsignado = $emailAsignado;

        return $this;
    }






}
