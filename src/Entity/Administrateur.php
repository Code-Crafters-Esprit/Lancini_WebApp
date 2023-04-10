<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdministrateurRepository;

#[ORM\Entity(repositoryClass: AdministrateurRepository::class)]
class Administrateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "pseudo", type: "string", length: 255, nullable: false)]

    private $pseudo;


    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "idUser", referencedColumnName: "idUser")]
    private $idUser;

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function getIduser(): ?User
    {
        return $this->idUser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->idUser = $iduser;

        return $this;
    }
}
