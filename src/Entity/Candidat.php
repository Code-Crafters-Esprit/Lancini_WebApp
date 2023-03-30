<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CandidatRepository;

#[ORM\Entity(repositoryClass: CandidatRepository::class)]
class Candidat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $idcandidat;

    #[ORM\Column(name: "secteur", type: "string", length: 255, nullable: false)]
    private $secteur;

    #[ORM\ManyToOne(targetEntity: "User", inversedBy: 'Candidat')]
    private $iduser;

    public function getIdcandidat(): ?int
    {
        return $this->idcandidat;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }
}
