<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExperienceRepository;


#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "idExperience", type: "integer", nullable: false)]
    private $idexperience;

    #[ORM\Column(name: "titre", type: "string", length: 255, nullable: false)]
    private $titre;

    #[ORM\Column(name: "description", type: "string", length: 255, nullable: true)]
    private $description;

    #[ORM\Column(name: "type", type: "string", length: 50, nullable: false)]
    private $type;

    #[ORM\Column(name: "lieu", type: "string", length: 50, nullable: true)]
    private $lieu;

    #[ORM\Column(name: "secteur", type: "string", length: 255, nullable: true)]
    private $secteur;

    #[ORM\Column(name: "dateDebut", type: "date", nullable: true)]
    private $datedebut;

    #[ORM\Column(name: "dateFin", type: "date", nullable: true)]
    private $datefin;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "idUser")]
    private $userId;
    public function getIdexperience(): ?int
    {
        return $this->idexperience;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(?string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(?\DateTimeInterface $datedebut): self
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

    public function getUserid(): ?User
    {
        return $this->userId;
    }

    public function setUserid(?User $userid): self
    {
        $this->userId = $userid;

        return $this;
    }
}
