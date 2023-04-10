<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReclamationRepository;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]

class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private  $id = null;
    #[ORM\Column(type: "string", length: 10, nullable: false)]
private $nom;

    #[ORM\Column(type: "string", length: 10, nullable: false)]
    private $prenom;
    
    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $description;
    
    #[ORM\Column(name: "sujetdereclamations", type: "string", length: 255, nullable: false)]
    private $sujetdereclamations;
    
    #[ORM\Column(type: "string", length: 150, nullable: false)]
    private $email;
    
    #[ORM\Column(type: "string", length: 100, nullable: false)]
    private $tel;
    
    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $etat;

    #[ORM\ManyToOne(targetEntity: "Avis", inversedBy: 'Reclamation')]

    private $idAvis=null;

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
