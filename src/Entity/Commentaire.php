<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentaireRepository;
use App\Entity\Publication;
use App\Entity\User;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]

class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private  $idcomm = null;

    
    #[ORM\Column(length:100)]
    private  $commentaire = null;


    #[ORM\ManyToOne(targetEntity: "Publication", inversedBy: 'Commentaire')]
    private  $idpub = null; 
 

    #[ORM\ManyToOne(targetEntity: "User", inversedBy: 'Commentaire')]
    private  $iduser = null; 

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
        return $this->idpub;
    }

    public function setIdpub(?Publication $idpub): self
    {
        $this->idpub = $idpub;

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