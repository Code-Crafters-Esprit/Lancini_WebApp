<?php

namespace App\Entity;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]

class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private  $id= null;
    #[ORM\Column(name: "nom", type: "string", length: 10, nullable: false)]     
      #[Assert\Regex( pattern:"/^[A-Za-z]+$/", message:"Le champ nom ne doit contenir que des lettres.")]
        private string $nom;    


    #[ORM\Column(name: "prenom", type: "string", length: 10, nullable: false)]
    
     
      #[Assert\Regex(pattern:"/^[A-Za-z]+$/",message:"Le champ prenom ne doit contenir que des lettres.")]
     
    private string $prenom;

    #[ORM\Column(name: "description", type: "string", length: 255, nullable: false)]
    private string $description;

    #[ORM\Column(name: "sujetdereclamations", type: "string", length: 255, nullable: false)]

  #[Assert\Regex(pattern:"/^[A-Za-z]+$/",message:"Le champ sujetdereclamations ne doit contenir que des lettres." )]
 
    private string $sujetdereclamations;

    #[ORM\Column(name: "email", type: "string", length: 150, nullable: false)]
     
     #[Assert\NotBlank()]
      #[Assert\Regex( pattern:"/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", message:"Le format de l'email '{{ value }}' n'est pas valide. Veuillez saisir une adresse email au format ****@***")]
     
    private string $email;

    #[ORM\Column(name: "tel", type: "string", length: 100, nullable: false)]
    
     
     #[Assert\Regex(
          pattern:"/^\+\d{1,3}\d{8,}$/",
          message:"Le numéro de téléphone '{{ value }}' n'est pas valide. Veuillez saisir un numéro de téléphone de la forme '+***' contenant au moins 8 chiffres."
      )]
     
    private string $tel;

    #[ORM\Column(name: "etat", type: "string", length: 255, nullable: false)]
    private string $etat;


    
    #[ORM\ManyToOne(targetEntity: Avis::class)]
    #[ORM\JoinColumn(name: "id", referencedColumnName: "id")]
    private $idAvis;

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

    public function getIdAvis(): ?Avis
    {
        return $this->idAvis;
    }
    

    public function setIdAvis(?Avis $idAvis): self
    {
        $this->idAvis = $idAvis;

        return $this;
    }



	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * @param mixed $id 
	 * @return self
	 */
	public function setId($id): self {
		$this->id = $id;
		return $this;
	}
}
