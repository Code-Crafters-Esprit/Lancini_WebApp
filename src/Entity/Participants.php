<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ParticipantsRepository;

#[ORM\Entity(repositoryClass: ParticipantsRepository::class)]

class Participants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idparticipant = null;

    #[ORM\ManyToOne(targetEntity: "Evenement", inversedBy: 'participants')]
    private ?Evenement $idevent = null; 

    #[ORM\ManyToOne(targetEntity: "User", inversedBy: 'participants')]
    private ?User $iduser = null; 

    public function getIdparticipant(): ?int
    {
        return $this->idparticipant;
    }

    public function getIdevent(): ?Evenement
    {
        return $this->idevent;
    }

    public function setIdevent(?Evenement $idevent): self
    {
        $this->idevent = $idevent;

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
