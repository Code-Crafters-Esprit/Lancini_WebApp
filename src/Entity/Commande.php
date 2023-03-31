<?php

namespace App\Entity;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;


#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private  $idCommande ;

    #[ORM\Column(name: "dateCommande", type: "datetime", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private $datecommande = null;

    #[ORM\Column(name: "montantPaye", type: "decimal", precision: 10, scale: 2, nullable: false)]
    private $montantpaye=null;

    #[ORM\ManyToOne(targetEntity: Produit::class)]
    #[ORM\JoinColumn(name: "produit", referencedColumnName: "idProduit")]
    private $produit;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "acheteur", referencedColumnName: "idUser")]
    private $acheteur;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "vendeur", referencedColumnName: "idUser")]
    private $vendeur;

    public function getIdcommande(): ?int
    {
        return $this->idCommande;
    }

    public function getDatecommande(): ?\DateTimeInterface
    {
        return $this->datecommande;
    }

    public function setDatecommande(\DateTimeInterface $datecommande): self
    {
        $this->datecommande = $datecommande;

        return $this;
    }

    public function getMontantpaye(): ?string
    {
        return $this->montantpaye;
    }

    public function setMontantpaye(string $montantpaye): self
    {
        $this->montantpaye = $montantpaye;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getAcheteur(): ?User
    {
        return $this->acheteur;
    }

    public function setAcheteur(?User $acheteur): self
    {
        $this->acheteur = $acheteur;

        return $this;
    }

    public function getVendeur(): ?User
    {
        return $this->vendeur;
    }

    public function setVendeur(?User $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }
    public function __toString() {
        return $this->idCommande;
    }
 
}
