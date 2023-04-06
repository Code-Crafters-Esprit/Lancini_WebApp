<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\OffreRepository;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: "integer", name: "idOffre")]
    private $idoffre;

    #[ORM\Column(type: "string", length: 255, name: "nom")]
    private $nom;

    #[ORM\Column(type: "string", length: 50, name: "typeOffre")]
    private $typeoffre;

    #[ORM\Column(type: "text", name: "description")]
    private $description;

    #[ORM\Column(type: "date", name: "dateDebut")]
    private $datedebut;

    #[ORM\Column(type: "date", name: "dateFin", nullable: true)]
    private $datefin;

    #[ORM\Column(type: "text", name: "competence")]
    private $competence;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "proprietaire", referencedColumnName: "idUser")]
    private $proprietaire;

    #[ORM\ManyToOne(targetEntity: Secteur::class)]
    #[ORM\JoinColumn(name: "idSecteur", referencedColumnName: "IdSecteur")]
    private $idsecteur;



    public function getIdoffre(): ?int
    {
        return $this->idoffre;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTypeoffre(): ?string
    {
        return $this->typeoffre;
    }

    public function setTypeoffre(string $typeoffre): self
    {
        $this->typeoffre = $typeoffre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getCompetence(): ?string
    {
        return $this->competence;
    }

    public function setCompetence(string $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    public function getIdsecteur(): ?Secteur
    {
        return $this->idsecteur;
    }

    public function setIdsecteur(?Secteur $idsecteur): self
    {
        $this->idsecteur = $idsecteur;

        return $this;
    }

    public function getProprietaire(): ?User
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?User $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }


}
