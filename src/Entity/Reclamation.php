<?php

namespace App\Entity;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;
/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity
 */
#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private  $id = null;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=10, nullable=false)
     */
    #[ORM\Column(name: "nom", type: "string", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private $nom;

    #[ORM\Column(name: "prenom", type: "string", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private $prenom;

    #[ORM\Column(name: "description", type: "string", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    
    private $description;

    #[ORM\Column(name: "sujetdereclamations", type: "string", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private $sujetdereclamations;

    #[ORM\Column(name: "email", type: "string", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    private $email;

    #[ORM\Column(name: "tel", type: "sring", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
    
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    #[ORM\Column(name: "etat", type: "string", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]

    private $etat;

    /**
     * @var \Avis
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Avis")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getSujetdereclamations(): ?string
    {
        return $this->sujetdereclamations;
    }

    public function setSujetdereclamations(string $sujetdereclamations): self
    {
        $this->sujetdereclamations = $sujetdereclamations;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getId(): ?Avis
    {
        return $this->id;
    }

    public function setId(?Avis $id): self
    {
        $this->id = $id;

        return $this;
    }


}
