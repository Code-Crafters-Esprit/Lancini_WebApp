<?php

namespace App\Entity;

use App\Repository\PostulationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'postulation')]
#[ORM\Entity(PostulationRepository::class)]
class Postulation
{

    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $id;

    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: 'Offre')]
    private ?Offre $offre;

    #[ORM\JoinColumn(name: 'id', referencedColumnName: 'id')]
    #[ORM\ManyToOne(targetEntity: 'User')]
    private ?User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
