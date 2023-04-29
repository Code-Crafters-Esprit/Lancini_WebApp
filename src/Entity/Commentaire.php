<?php

namespace App\Entity;
use App\Entity\Publication;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CommentaireRepository;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]

class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    #[ORM\Column(length:100)]
    #[Assert\NotBlank(message:"Please fill out this field and respect our ethics")]
    #[Assert\Length(max: 30)]
    private ?string $commentaire = null;


    #[ORM\ManyToOne(targetEntity: Publication::class)]
    #[ORM\JoinColumn(name: 'idpub', referencedColumnName: 'idpub', nullable: true)]
    private ?Publication $idpub = null; 

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'iduser', referencedColumnName: 'idUser', nullable: true)]
    private ?User $iduser = null; 


    public function getIdcomm(): ?int
    {
        return $this->id;
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