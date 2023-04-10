<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentaireRepository;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]

class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idcomm = null;

    
    #[ORM\Column(length:100)]
    private ?string $commentaire = null;


    #[ORM\ManyToOne(targetEntity: Publication::class)]
    #[ORM\JoinColumn(name: "idPub", referencedColumnName: "idPub")]
    private $idPub;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "idUser", referencedColumnName: "idUser")]
    private $idUser;
    public function getIdcomm(): ?int
    {
        return $this->idcomm;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getIdpub(): ?Publication
    {
        return $this->idPub;
    }

    public function setIdpub(?Publication $idpub): self
    {
        $this->idPub = $idpub;

        return $this;
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