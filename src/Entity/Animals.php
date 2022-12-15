<?php

namespace App\Entity;

use App\Repository\AnimalsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimalsRepository::class)
 */
class Animals
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=14)
     */
    private $numero_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="date")
     */
    private $date_arrivee;

    public function __construct()
    {
        $this->date_arrivee = new \DateTime();
    }

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_depart;

    /**
     * @ORM\Column(type="boolean")
     */
    private $zoo_proprietaire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $espece;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $male;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sterilise;

    /**
     * @ORM\Column(type="boolean")
     */
    private $quarantaine;

    /**
     * @ORM\ManyToOne(targetEntity=Enclos::class, inversedBy="animals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enclos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroId(): ?string
    {
        return $this->numero_id;
    }

    public function setNumeroId(string $numero_id): self
    {
        $this->numero_id = $numero_id;

        return $this;
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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->date_arrivee;
    }

    public function setDateArrivee(\DateTimeInterface $date_arrivee): self
    {
        $this->date_arrivee = $date_arrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->date_depart;
    }

    public function setDateDepart(?\DateTimeInterface $date_depart): self
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    public function isZooProprietaire(): ?bool
    {
        return $this->zoo_proprietaire;
    }

    public function setZooProprietaire(bool $zoo_proprietaire): self
    {
        $this->zoo_proprietaire = $zoo_proprietaire;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(?string $espece): self
    {
        $this->espece = $espece;

        return $this;
    }

    public function isMale(): ?bool
    {
        return $this->male;
    }

    public function setMale(?bool $male): self
    {
        $this->male = $male;

        return $this;
    }

    public function isSterilise(): ?bool
    {
        return $this->sterilise;
    }

    public function setSterilise(bool $sterilise): self
    {
        $this->sterilise = $sterilise;

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

    public function getEnclos(): ?Enclos
    {
        return $this->enclos;
    }

    public function setEnclos(?Enclos $enclos): self
    {
        $this->enclos = $enclos;

        return $this;
    }
}
