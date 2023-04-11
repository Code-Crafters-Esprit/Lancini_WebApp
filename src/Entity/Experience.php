<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
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
    #[Assert\NotBlank(message: "The title field is required")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The title cannot be longer than {{ limit }} characters"
    )]
    private $titre;

    #[ORM\Column(name: "description", type: "string", length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: "The description cannot be longer than {{ limit }} characters"
    )]
    private $description;

    #[ORM\Column(name: "type", type: "string", length: 50, nullable: false)]
    #[Assert\NotBlank(message: "The type field is required")]
    #[Assert\Length(
        max: 50,
        maxMessage: "The type cannot be longer than {{ limit }} characters"
    )]
    private $type;

    #[ORM\Column(name: "lieu", type: "string", length: 50, nullable: true)]
    #[Assert\Length(
        max: 50,
        maxMessage: "The location cannot be longer than {{ limit }} characters"
    )]
    private $lieu;

    #[ORM\Column(name: "secteur", type: "string", length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: "The sector cannot be longer than {{ limit }} characters"
    )]
    private $secteur;

    #[ORM\Column(name: "dateDebut", type: "date", nullable: false)]
    #[Assert\NotBlank(message: "The start date field is required")]
    private $datedebut;

    #[ORM\Column(name: "dateFin", type: "date", nullable: false)]
    #[Assert\NotBlank(message: "The end date field is required")]
    #[Assert\GreaterThan(
        propertyPath: "datedebut",
        message: "The end date must be greater than the start date"
    )]
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
