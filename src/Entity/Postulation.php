<?php

namespace App\Entity;

use App\Repository\PostulationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'postulation')]
#[ORM\Index(columns: ['idUser', 'idOffre'], name: 'idUser')]
#[ORM\Index(columns: ['idOffre', 'idUser'], name: 'idOffre')]
#[ORM\Index(columns: ['idOffre'], name: 'IDX_DA7D4E9BB842C572')]
#[ORM\Index(columns: ['idUser'], name: 'IDX_DA7D4E9BFE6E88D7')]
#[ORM\Entity(PostulationRepository::class)]
class Postulation
{

    #[ORM\Column(name: 'idPost', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $idpost;

    #[ORM\JoinColumn(name: 'idOffre', referencedColumnName: 'idOffre', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: 'Offre')]
    private ?Offre $idoffre;

    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'idUser')]
    #[ORM\ManyToOne(targetEntity: 'User')]
    private ?User $iduser;

    public function getIdpost(): ?int
    {
        return $this->idpost;
    }

    public function getIdoffre(): ?Offre
    {
        return $this->idoffre;
    }

    public function setIdoffre(?Offre $idoffre): self
    {
        $this->idoffre = $idoffre;

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
