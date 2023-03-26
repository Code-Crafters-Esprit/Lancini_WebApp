<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AdministrateurRepository;

#[ORM\Entity(repositoryClass: AdministrateurRepository::class)]
class Administrateur
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private $pseudo;

    #[ORM\ManyToOne(targetEntity: "User", inversedBy: 'Administrateur')]

    private $iduser=null;

    public function getPseudo(): ?string
    {
        return $this->pseudo;
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
