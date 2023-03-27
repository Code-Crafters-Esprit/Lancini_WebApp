<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "idUser", type: "integer", nullable: false)]

    private  $iduser;

    #[ORM\Column(name: "Nom", type: "string", length: 255, nullable: false)]
    private $nom;

    #[ORM\Column(name: "Prenom", type: "string", length: 255, nullable: false)]
    private $prenom;

    #[ORM\Column(name: "email", type: "string", length: 255, nullable: false)]
    private $email;

    #[ORM\Column(name: "motDePasse", type: "string", length: 255, nullable: false)]
    private $motdepasse;

    #[ORM\Column(name: "role", type: "string", length: 255, nullable: false)]
    private $role;

    #[ORM\Column(name: "bio", type: "string", length: 65535, nullable: false)]
    private $bio;

    #[ORM\Column(name: "photoPath", type: "string", length: 255, nullable: false)]
    private $photopath;

    #[ORM\Column(name: "numTel", type: "string", length: 255, nullable: false)]
    private $numtel;

    public function getIduser(): ?int
    {
        return $this->iduser;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getPhotopath(): ?string
    {
        return $this->photopath;
    }

    public function setPhotopath(?string $photopath): self
    {
        $this->photopath = $photopath;

        return $this;
    }

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(?string $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

         
        public function __toString() {
         
            return sprintf('%s %s', $this->getNom(), $this->getPrenom());
            }
}
