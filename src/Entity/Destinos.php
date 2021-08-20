<?php

namespace App\Entity;

use App\Repository\DestinosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DestinosRepository::class)
 */
class Destinos
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
    private $email;

    /**
     * @ORM\OneToMany(targetEntity=CategoriaPrincipal::class, mappedBy="destinos", cascade={"remove"})
     */
    private $categoriaPP;

    public function __construct()
    {
        $this->categoriaPP = new ArrayCollection();
    }

  

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|CategoriaPrincipal[]
     */
    public function getCategoriaPP(): Collection
    {
        return $this->categoriaPP;
    }

    public function addCategoriaPP(CategoriaPrincipal $categoriaPP): self
    {
        if (!$this->categoriaPP->contains($categoriaPP)) {
            $this->categoriaPP[] = $categoriaPP;
            $categoriaPP->setDestinos($this);
        }

        return $this;
    }

    public function removeCategoriaPP(CategoriaPrincipal $categoriaPP): self
    {
        if ($this->categoriaPP->removeElement($categoriaPP)) {
            // set the owning side to null (unless already changed)
            if ($categoriaPP->getDestinos() === $this) {
                $categoriaPP->setDestinos(null);
            }
        }

        return $this;
    }

   







  



}
