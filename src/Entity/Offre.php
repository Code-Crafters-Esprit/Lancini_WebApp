<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'offre')]
#[ORM\Index(columns: ['proprietaire'], name: 'proprietaire')]
#[ORM\Index(columns: ['idSecteur'], name: 'offre_ibfk_21')]
#[ORM\Entity(OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\Column(name: 'idOffre', type: 'integer', nullable: false)]
    #[ORM\GeneratedValue]
    private int $idOffre;

    #[ORM\Column(name: 'nom', type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank(message:'The field must not be empty.')]
    private string $nom;

    #[ORM\Column(name: 'typeOffre', type: 'string', length: 50, nullable: false)]
    #[Assert\NotBlank(message:'The field must not be empty.')]
    private string $typeoffre;

    #[ORM\Column(name: 'description', type: 'text', length: 65535, nullable: false)]
    #[Assert\NotBlank(message:'The field must not be empty.')]
    private string $description;

    #[ORM\Column(name: 'dateDebut', type: 'date', nullable: false)]
    private DateTime $datedebut;

    #[ORM\Column(name: 'dateFin', type: 'date', nullable: true)]
    private ?DateTime $datefin;

    #[ORM\Column(name: 'competence', type: 'text', length: 65535, nullable: false)]
    #[Assert\NotBlank(message:'The field must not be empty.')]
    private string $competence;

    #[ORM\JoinColumn(name: 'idSecteur', referencedColumnName: 'IdSecteur')]
    #[ORM\ManyToOne(targetEntity: 'Secteur', cascade: ['all'], fetch: 'EAGER')]
    #[Assert\NotBlank(message:'The field must not be empty.')]
    private ?Secteur $secteur;

    #[ORM\JoinColumn(name: 'proprietaire', referencedColumnName: 'idUser')]
    #[ORM\ManyToOne(targetEntity: 'User', cascade: ['all'], fetch: 'EAGER')]
    private ?User $proprietaire;

    #[ORM\OneToMany(mappedBy: 'idoffre', targetEntity: 'App\Entity\Postulation', cascade: ['persist', 'remove'])]
    private Collection $postulation;

    public function __construct()
    {
        $this->postulation = new ArrayCollection();
    }

    public function getIdOffre(): ?int
    {
        return $this->idOffre;
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

    public function getTypeoffre(): ?string
    {
        return $this->typeoffre;
    }

    public function setTypeoffre(string $typeoffre): self
    {
        $this->typeoffre = $typeoffre;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getCompetence(): ?string
    {
        return $this->competence;
    }

    public function setCompetence(string $competence): self
    {
        $this->competence = $competence;

        return $this;
    }

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): self
    {
        $this->secteur = $secteur;

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

    public function getPostulation(): ArrayCollection
    {
        return $this->postulation;
    }

    public function setPostulation(ArrayCollection $postulation): self
    {
        $this->postulation = $postulation;

        return $this;
    }

    public function addPostulation(Postulation $postulation): self
    {
        if (!$this->postulation->contains($postulation)) {
            $this->postulation->add($postulation);
            $postulation->setIdoffre($this);
        }

        return $this;
    }

    public function removePostulation(Postulation $postulation): self
    {
        // set the owning side to null (unless already changed)
        if ($this->postulation->removeElement($postulation) && $postulation->getIdoffre() === $this) {
            $postulation->setIdoffre(null);
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getNom() . ' - ' . $this->getDescription(). ' - ' . $this->getCompetence(). ' - ' .$this->getTypeoffre() ;


    }
}
