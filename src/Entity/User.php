<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'user')]
#[ORM\UniqueConstraint(name: 'email', columns: ['email'])]
#[ORM\Entity]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    private int $id;

    #[ORM\Column(name: 'nom', type: 'string', length: 255, nullable: false)]
    private string $nom;

    #[ORM\Column(name: 'Prenom', type: 'string', length: 255, nullable: false)]
    private string $prenom;

    #[ORM\Column(name: 'email', type: 'string', length: 255, nullable: false)]
    private string $email;

    #[ORM\Column(name: 'motDePasse', type: 'string', length: 255, nullable: false)]
    private string $motdepasse;

    #[ORM\Column(name: 'role', type: 'string', length: 255, nullable: false)]
    private string $role;

    #[ORM\Column(name: 'bio', type: 'text', length: 65535, nullable: true)]
    private ?string $bio;

    #[ORM\Column(name: 'photoPath', type: 'string', length: 255, nullable: true)]
    private ?string $photopath;

    #[ORM\Column(name: 'numTel', type: 'string', length: 255, nullable: true)]
    private ?string $numtel;

    #[ORM\OneToMany(mappedBy: 'userid', targetEntity: 'App\Entity\Badge', cascade: ['persist'])]
    private Collection $badge;

    #[ORM\OneToMany(mappedBy: 'proprietaire', targetEntity: 'Offre', cascade: ['persist'])]
    private Collection $offre;

    public function __construct()
    {
        $this->offre = new ArrayCollection();
        $this->badge = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): string
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function getPhotopath(): ?string
    {
        return $this->photopath;
    }

    public function setPhotopath(?string $photopath): self
    {
        $this->photopath = $photopath;

        return $this;
    }

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(?string $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

  /*  public function getBadge(): ArrayCollection
    {
        return $this->badge;
    }
*/
    public function setBadge(ArrayCollection $badge): self
    {
        $this->badge = $badge;

        return $this;
    }

  /*  public function getOffre(): ArrayCollection
    {
        return $this->offre;
    }
*/
    public function setOffre(ArrayCollection $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offre->contains($offre)) {
            $this->offre[] = $offre;
            $offre->setProprietaire($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        // set the owning side to null (unless already changed)
        if ($this->offre->removeElement($offre) && $offre->getProprietaire() === $this) {
            $offre->setProprietaire(null);
        }

        return $this;
    }

    public function addBadge(Badge $badge): self
    {
        if (!$this->badge->contains($badge)) {
            $this->badge->add($badge);
            $badge->setUserid($this);
        }

        return $this;
    }

    public function removeBadge(Badge $badge): self
    {
        // set the owning side to null (unless already changed)
        if ($this->badge->removeElement($badge) && $badge->getUserid() === $this) {
            $badge->setUserid(null);
        }

        return $this;
    }
}
