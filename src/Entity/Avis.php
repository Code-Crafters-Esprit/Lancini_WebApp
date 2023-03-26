<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AvisRepository;


#[ORM\Entity(repositoryClass: AvisRepository::class)]

class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idAvis = null;


    #[ORM\Column(length:100)]
    private ?string $description = null;
    

    #[ORM\Column]
    private ?int $note = null;




    #[ORM\Column]
    private ?Date $date = null;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProduit", referencedColumnName="idProduit")
     * })
     */
    #[ORM\Column]
    private ?int $idproduit = null;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEvaluateurUser", referencedColumnName="idUser")
     * })
     */
    private $idevaluateuruser;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

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

    public function getIdproduit(): ?Produit
    {
        return $this->idproduit;
    }

    public function setIdproduit(?Produit $idproduit): self
    {
        $this->idproduit = $idproduit;

        return $this;
    }

    public function getIdevaluateuruser(): ?User
    {
        return $this->idevaluateuruser;
    }

    public function setIdevaluateuruser(?User $idevaluateuruser): self
    {
        $this->idevaluateuruser = $idevaluateuruser;

        return $this;
    }


}
