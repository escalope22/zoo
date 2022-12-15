<?php

namespace App\Entity;

use App\Repository\EnclosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnclosRepository::class)
 */
class Enclos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $superficie;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacite;

    /**
     * @ORM\Column(type="boolean")
     */
    private $quarantaine;

    /**
     * @ORM\ManyToOne(targetEntity=Espaces::class, inversedBy="enclos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $espace;

    /**
     * @ORM\OneToMany(targetEntity=Animals::class, mappedBy="enclos")
     */
    private $animals;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSuperficie(): ?int
    {
        return $this->superficie;
    }

    public function setSuperficie(int $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function isQuarantaine(): ?bool
    {
        return $this->quarantaine;
    }

    public function setQuarantaine(bool $quarantaine): self
    {
        $this->quarantaine = $quarantaine;

        return $this;
    }

    public function getEspace(): ?Espaces
    {
        return $this->espace;
    }

    public function setEspace(?Espaces $espace): self
    {
        $this->espace = $espace;

        return $this;
    }

    /**
     * @return Collection<int, Animals>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animals $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals[] = $animal;
            $animal->setEnclos($this);
        }

        return $this;
    }

    public function removeAnimal(Animals $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getEnclos() === $this) {
                $animal->setEnclos(null);
            }
        }

        return $this;
    }
}
