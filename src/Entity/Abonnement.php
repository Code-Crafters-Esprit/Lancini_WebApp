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
    private $idabonnement;

    #[ORM\ManyToOne(targetEntity: "User", inversedBy: 'Abonnement')]
    private $useridfollowed;

    #[ORM\ManyToOne(targetEntity: "User", inversedBy: 'Abonnement')]
    private $userid;

    public function getIdabonnement(): ?int
    {
        return $this->idabonnement;
    }

    public function getUseridfollowed(): ?User
    {
        return $this->useridfollowed;
    }

    public function setUseridfollowed(?User $useridfollowed): self
    {
        $this->useridfollowed = $useridfollowed;

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
