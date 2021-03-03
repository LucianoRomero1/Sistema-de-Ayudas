<?php

namespace App\Entity;

use App\Repository\ContactoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactoRepository::class)
 */
class Contacto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable = true)
     */
    
    private $nombre;

    /**
     * @ORM\Column(type="string", length=100, nullable = true)
     */
    private $apellido;

    /**
     * @ORM\Column(type="string", length=100 )
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable = true)
     */
    private $motivo_contacto;

    /**
     * @ORM\Column(type="date", nullable = true)
     */
    private $fecha_envio;

    /**
     * @ORM\Column(type="string", nullable = true)
     */
    private $dni;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $telefono;

   

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $codigoArea;

    /**
     * @ORM\OneToMany(targetEntity=Archivos::class, mappedBy="contacto", cascade={"persist"})
     */
    private $archivos;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $documento = [];

    public function __construct()
    {
        $this->archivos = new ArrayCollection();
    }

   

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMotivoContacto(): ?string
    {
        return $this->motivo_contacto;
    }

    public function setMotivoContacto(string $motivo_contacto): self
    {
        $this->motivo_contacto = $motivo_contacto;

        return $this;
    }

    public function getFechaEnvio(): ?\DateTimeInterface
    {
        return $this->fecha_envio;
    }

    public function setFechaEnvio(\DateTimeInterface $fecha_envio): self
    {
        $this->fecha_envio = $fecha_envio;

        return $this;
    }

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

 

    public function getCodigoArea(): ?string
    {
        return $this->codigoArea;
    }

    public function setCodigoArea(?string $codigoArea): self
    {
        $this->codigoArea = $codigoArea;

        return $this;
    }

    /**
     * @return Collection|Archivos[]
     */
    public function getArchivos(): Collection
    {
        return $this->archivos;
    }

    public function addArchivo(Archivos $archivo): self
    {
        if (!$this->archivos->contains($archivo)) {
            $this->archivos[] = $archivo;
            $archivo->setContacto($this);
        }

        return $this;
    }

    public function removeArchivo(Archivos $archivo): self
    {
        if ($this->archivos->removeElement($archivo)) {
            // set the owning side to null (unless already changed)
            if ($archivo->getContacto() === $this) {
                $archivo->setContacto(null);
            }
        }

        return $this;
    }

    public function getDocumento(): ?array
    {
        return $this->documento;
    }

    public function setDocumento(?array $documento): self
    {
        $this->documento = $documento;

        return $this;
    }


   









}
