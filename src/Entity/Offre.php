<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table(name="offre", indexes={@ORM\Index(name="proprietaire", columns={"proprietaire"}), @ORM\Index(name="offre_ibfk_21", columns={"idSecteur"})})
 * @ORM\Entity
 */
class Offre
{
    /**
     * @ORM\Id
     * @ORM\Column(name="idOffre", type="integer", nullable=false)
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $idOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private string $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="typeOffre", type="string", length=50, nullable=false)
     */
    private string $typeoffre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private string $description;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="dateDebut", type="date", nullable=false)
     */
    private DateTime $datedebut;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="dateFin", type="date", nullable=true)
     */
    private ?DateTime $datefin;

    /**
     * @var string
     *
     * @ORM\Column(name="competence", type="text", length=65535, nullable=false)
     */
    private string $competence;

    /**
     * @var Secteur
     *
     * @ORM\ManyToOne(targetEntity="Secteur", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSecteur", referencedColumnName="IdSecteur")
     * })
     */
    private ?Secteur $secteur;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proprietaire", referencedColumnName="idUser")
     * })
     */
    private ?User $proprietaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Postulation", mappedBy="idoffre", cascade={"persist", "remove"})
     */
    private $postulation;

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
        if ($this->postulation->removeElement($postulation)) {
            // set the owning side to null (unless already changed)
            if ($postulation->getIdoffre() === $this) {
                $postulation->setIdoffre(null);
            }
        }

        return $this;
    }
}
