<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CvRepository;

#[ORM\Entity(repositoryClass: CvRepository::class)]
class Cv
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "idCV", type: "integer", nullable: false)]
    private $idcv;

    #[ORM\Column(type: "integer", nullable: false)]
    private $cin;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $nom;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $prenom;

    #[ORM\Column(type: "string", length: 10, nullable: false)]
    private $sexe;

    #[ORM\Column(type: "date", nullable: true)]
    private $datenaissance;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $photo = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $adresse = null;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private  $email;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private  $langue = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private  $education = null;

   
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "idUser")]
    private $userid = null;

    public function getIdcv(): ?int
    {
        return $this->idcv;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDatenaissance(): ?\DateTimeInterface
    {
        return $this->datenaissance;
    }

    public function setDatenaissance(?\DateTimeInterface $datenaissance): self
    {
        $this->datenaissance = $datenaissance;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(?string $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getUserid(): ?User
    {
        return $this->userid;
    }

    public function setUserid(?User $userid): self
    {
        $this->userid = $userid;

        return $this;
    }


}
