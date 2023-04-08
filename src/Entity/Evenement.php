<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\EvenementRepository;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]

class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idevent = null;

    #[ORM\Column(length:30)]
    #[Assert\Length(max: 30)]
    private ?string $titre = null;

    #[ORM\Column(length:100)]
    #[Assert\Length(max: 100)]
    private ?string $sujet = null;
    
    #[ORM\Column(length:50)]
    #[Assert\Length(max: 50)]
    private ?string $lieu = null;

    #[ORM\Column(length:10)]
    #[Assert\Length(max: 10)]
    private ?string $horaire = null;
    
    #[ORM\Column()]
    private ?string $dateevent = null;
   
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'proprietaire', referencedColumnName: 'idUser', nullable: true)]
    private ?User $proprietaire = null; 

    

    public function getIdevent(): ?int
    {
        return $this->idevent;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getHoraire(): ?string
    {
        return $this->horaire;
    }

    public function setHoraire(string $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getDateevent(): ?string
    {
        return $this->dateevent;
    }

    public function setDateevent(string $dateevent): self
    {
        $this->dateevent = $dateevent;

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
