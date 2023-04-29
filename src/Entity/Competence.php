<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(name: "libelle", type: "string", length: 255, nullable: false)]
    private $libelle;

 
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "idUser")]
    private $userId;
    public function getLibelle(): ?string
    {
        return $this->libelle;
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
