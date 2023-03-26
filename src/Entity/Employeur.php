<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Repository\EmployeurRepository;

#[ORM\Entity(repositoryClass: EmployeurRepository::class)]

class Employeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private  $idemployeur = null;
    #[ORM\Column(name: "companyName", type: "string", length: 255)]
    private $companyname;
    
    #[ORM\Column(name: "secteur", type: "string", length: 255)]
    private $secteur;
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "idUser", referencedColumnName: "idUser")]
   
    private  $iduser = null;
    public function getIdemployeur(): ?int
    {
        return $this->idemployeur;
    }

    public function getCompanyname(): ?string
    {
        return $this->companyname;
    }

    public function setCompanyname(string $companyname): self
    {
        $this->companyname = $companyname;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

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
