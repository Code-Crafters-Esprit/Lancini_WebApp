<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SecteurRepository;



#[ORM\Entity(repositoryClass: SecteurRepository::class)]
class Secteur {
#[ORM\Column(name: "IdSecteur", type: "integer", nullable: false)]
#[ORM\Id]
#[ORM\GeneratedValue(strategy: "IDENTITY")]
private $idsecteur;

#[ORM\Column(name: "nom", type: "string", length: 25, nullable: false)]
private $nom;

#[ORM\Column(name: "description", type: "text", length: 65535, nullable: false)]
private $description;

#[ORM\Column(name: "DateCreation", type: "date", nullable: false)]
private $datecreation;

#[ORM\Column(name: "DateModification", type: "date", nullable: true)]
private $datemodification;
  

    public function getIdsecteur(): ?int
    {
        return $this->idsecteur;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getDatemodification(): ?\DateTimeInterface
    {
        return $this->datemodification;
    }

    public function setDatemodification(?\DateTimeInterface $datemodification): self
    {
        $this->datemodification = $datemodification;

        return $this;
    }


}
