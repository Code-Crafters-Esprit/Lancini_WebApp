<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
 

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: "idProduit", type: "integer", nullable: false)]
    #[Groups("produits")]
    private $idProduit;

    #[ORM\Column(name: 'categorie', type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Please enter a category')]
    #[Assert\Length(max: 255, maxMessage: 'Category name should not exceed {{ limit }} characters')]
    #[Groups("produits")]
    private $categorie;

    #[ORM\Column(name: 'nom', type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Please enter a name')]
    #[Assert\Length(max: 255, maxMessage: 'Name should not exceed {{ limit }} characters')]
    #[Groups("produits")]
    private $nom;

    #[ORM\Column(name: 'description', type: 'text', length: 65535, nullable: false)]
    #[Assert\NotBlank(message: 'Please enter a description')]
    #[Assert\Length(max: 100, maxMessage: 'Description should not exceed {{ limit }} characters')]
    #[Groups("produits")]
    private $description;
    #[ORM\Column(name: "image", type:"string", length:255, nullable: false, options: ["default" => "default_image.png"])]
    #[Groups("produits")]
    private $image="img.jpg";

    
    #[Assert\Image(maxSize :"5M",maxSizeMessage : "The maximum allowed file size is {{ limit }}", mimeTypes :["image/png", "image/jpeg", "image/jpg", "image/gif"], mimeTypesMessage :"Please upload a valid image file")]
    #[Vich\UploadableField(mapping: "products", fileNameProperty: "image")]
    private $imageFile;


    #[ORM\Column(name: 'prix', type: 'decimal', precision: 10, scale: 2)]
    #[Assert\PositiveOrZero(message: 'Price should be a positive value')]
    #[Assert\Length(max: 4, maxMessage: 'Maximum 4 digits, only numbers allowed')]
    #[Groups("produits")]

    private $prix;

    #[ORM\Column(name: 'date', type: 'datetime', nullable: false, options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Groups("produits")]
    private $date;
    #[ORM\Column(name: 'vendeur', type: 'string', nullable: true)]
  
    private $vendeur ="vendeur";

   /* #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'vendeur', referencedColumnName: 'idUser')]
    #[Assert\NotBlank(message: "You must pick a Seller.")]
    #[Groups("produits")]
    private $vendeur;
*/
    public function getidProduit(): ?int
    {
        return $this->idProduit;
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

    public function setImageFile(File $image = null): void
    {
        $this->imageFile = $image;

        if ($image) {
            $this->date = new DateTime();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
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


   /* public function getVendeur(): ?User
    {
        return $this->vendeur;
    } */
    public function getVendeur(): ?string
    {
        return $this->vendeur;
    }
    public function setVendeur(?User $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function __toString() {
        return $this->nom ;
    }
    
    public function __construct()
    {
        $this->image = 'default_image.png';
    }
}