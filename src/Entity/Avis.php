<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AvisRepository;
use Symfony\Component\Validator\Constraints\Date;
use App\Entity\User;

#[ORM\Entity(repositoryClass: AvisRepository::class)]

class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id = null;

    #[ORM\Column(length:100)]
    private  $description = null;

    #[ORM\Column]
    private $note = null;

    #[ORM\Column(type: "date")]
    private  $date = null;
    #[ORM\ManyToOne(targetEntity: Produit::class)]
    #[ORM\JoinColumn(name: "idProduit", referencedColumnName: "idProduit")]
    private $idproduit;


    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "idevaluateuruser", referencedColumnName: "idUser")]
    private $idevaluateuruser;
 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdproduit(): ?Produit
    {
        return $this->idproduit;
    }

    public function setIdproduit(?Produit $idproduit): self
    {
        $this->idproduit = $idproduit;

        return $this;
    }

    public function getIdevaluateuruser(): ?User
    {
        return $this->idevaluateuruser;
    }

    public function setIdevaluateuruser(?User $idevaluateuruser): self
    {
        $this->idevaluateuruser = $idevaluateuruser;

        return $this;
    }

    public function getIdAvis(): ?string
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->description;
    }

}