<?php

namespace App\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use App\Entity\User;



#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{ #[ORM\Column(name: "idProduit", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private  $idproduit;

    #[ORM\Column(name: "categorie", type: "string", length: 255, nullable: false)]
    private  $categorie;

    #[ORM\Column(name: "nom", type: "string", length: 255, nullable: false)]
    private  $nom;

    #[ORM\Column(name: "description", type: "text", length: 65535, nullable: false)]
    private  $description;

    #[ORM\Column(name: "image", type: "string", length: 255, nullable: false)]
    private  $image;

    #[ORM\Column(name: "prix", type: "decimal", precision: 10, scale: 2, nullable: false)]
    private  $prix;

    #[ORM\Column(name: "date", type: "datetime", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private  $date;

    #[ORM\ManyToOne(targetEntity: "User", inversedBy: 'Produit')]

    private  $vendeur=null;

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

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

    public function getVendeur(): ?User
    {
        return $this->vendeur;
    }

    public function setVendeur(?User $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }


}
