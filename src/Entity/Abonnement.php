<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
class Abonnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "idAbonnement", type: "integer", nullable: false)]
    private $idAbonnement;

   
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userid", referencedColumnName: "idUser")]
    private $userid;

 
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "useridFollowed", referencedColumnName: "idUser")]
    private $useridFollowed;

    public function getIdabonnement(): ?int
    {
        return $this->idAbonnement;
    }

    public function getUseridfollowed(): ?User
    {
        return $this->useridFollowed;
    }

    public function setUseridfollowed(?User $useridfollowed): self
    {
        $this->useridFollowed = $useridfollowed;

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
