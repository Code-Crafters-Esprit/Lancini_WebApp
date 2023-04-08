<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\PublicationRepository;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]

class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idpub = null;
    

    #[ORM\Column(length:30)]
    #[Assert\NotBlank(message:"Please  fill out the title")]
    private ?string $libelle = null;
    

    #[ORM\Column]
    private ?string $datepub = null;

    #[ORM\Column(length:100)]
    #[Assert\Length(max:100)]
    private ?string $description = null;

    #[ORM\Column(length:30)]
    #[Assert\Length(max:30)]
    private ?string $cat = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'proprietaire', referencedColumnName: 'idUser', nullable: true)]
    private ?User $proprietaire = null; 

    public function getIdpub(): ?int
    {
        return $this->idpub;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDatepub(): ?string
    {
        return $this->datepub;
    }

    public function setDatepub(string $datepub): self
    {
        $this->datepub = $datepub;

        return $this;
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

    public function getCat(): ?string
    {
        return $this->cat;
    }

    public function setCat(string $cat): self
    {
        $this->cat = $cat;

        return $this;
    }

    public function getProprietaire(): ?User
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?User $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

}
