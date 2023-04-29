<?php

namespace App\Entity;

use App\Repository\PostulationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'postulation')]
#[ORM\Index(name: 'idUser', columns: ['idUser', 'idOffre'])]
#[ORM\Index(name: 'idOffre', columns: ['idOffre', 'idUser'])]
#[ORM\Index(name: 'IDX_DA7D4E9BB842C572', columns: ['idOffre'])]
#[ORM\Index(name: 'IDX_DA7D4E9BFE6E88D7', columns: ['idUser'])]
#[ORM\Entity(PostulationRepository::class)]
class Postulation
{

    #[ORM\Column(name: 'idPost', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $idpost;

    #[ORM\JoinColumn(name: 'idOffre', referencedColumnName: 'idOffre', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: 'Offre')]
    private ?Offre $idoffre=null;

    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'idUser')]
    #[ORM\ManyToOne(targetEntity: 'User')]
    private ?User $iduser=null;

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
