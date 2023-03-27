<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'secteur')]
#[ORM\Entity]
class Secteur
{
    #[ORM\Column(name: 'IdSecteur', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $idsecteur;

    #[ORM\Column(name: 'nom', type: 'string', length: 25, nullable: false)]
    private string $nom;

    #[ORM\Column(name: 'description', type: 'text', length: 65535, nullable: false)]
    private string $description;

    #[ORM\Column(name: 'DateCreation', type: 'date', nullable: false)]
    private \DateTime $datecreation;

    #[ORM\Column(name: 'DateModification', type: 'date', nullable: true)]
    private \DateTime|null $datemodification;

    #[ORM\OneToMany(targetEntity: 'Offre', mappedBy: 'secteur', cascade: ['persist', 'remove'])]
    private Collection $offre;

    public function __construct()
    {
        $this->offre = new ArrayCollection();
    }

    public function getIdsecteur(): ?int
    {
        return $this->idsecteur;
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

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getDatemodification(): ?\DateTimeInterface
    {
        return $this->datemodification;
    }

    public function setDatemodification(?\DateTimeInterface $datemodification): self
    {
        $this->datemodification = $datemodification;

        return $this;
    }


    public function getOffre()
    {
        return $this->offre;
    }

    public function setOffre($offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offre->contains($offre)) {
            $this->offre[] = $offre;
            $offre->setSecteur($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        // set the owning side to null (unless already changed)
        if ($this->offre->removeElement($offre) && $offre->getSecteur() === $this) {
            $offre->setSecteur(null);
        }

        return $this;
    }
}
