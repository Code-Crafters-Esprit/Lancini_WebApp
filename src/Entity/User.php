<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\Collection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Table(name: 'user')]
#[ORM\UniqueConstraint(name: 'email', columns: ['email'])]
#[ORM\Entity]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(name: 'idUser', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $idUser;

    #[ORM\Column(name: 'nom', type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Please enter a name')]
    #[Assert\Length(max: 255, maxMessage: 'Name should not exceed {{ limit }} characters')]
    private string $nom;

    #[ORM\Column(name: 'Prenom', type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Please enter a prename')]
    #[Assert\Length(max: 255, maxMessage: 'Name should not exceed {{ limit }} characters')]
    private string $prenom;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(name: 'email', type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank(message: "Please enter an email")]
    #[Assert\Email(message: "Please enter a valid email address")]
    private string $email;

    #[Assert\NotBlank(message: "Please enter a password")]
    #[Assert\Length(min: 8, max: 255, minMessage: "Password should be at least {{ limit }} characters long", maxMessage: "Password should not exceed {{ limit }} characters")]
    #[Assert\Regex(
        pattern: "/^(?=.*[a-zA-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/",
        message: "Password must contain at least one letter and one number"
    )]
    #[ORM\Column(name: 'motDePasse', type: 'string', length: 255, nullable: false)]
    private string $motdepasse;

    #[Assert\NotBlank(message: "Please enter a role")]
    #[Assert\Length(max: 255, maxMessage: "Role should not exceed {{ limit }} characters")]
    #[ORM\Column(name: 'role', type: 'string', length: 255, nullable: false)]
    private string $role;

    #[Assert\Length(max: 65535, maxMessage: "Bio should not exceed {{ limit }} characters")]
    #[ORM\Column(name: 'bio', type: 'text', length: 65535, nullable: true)]
    private ?string $bio;

    #[ORM\Column(name: 'photoPath', type: 'string', length: 255, nullable: true)]
    private ?string $photopath = null;


    /**
     * @var File|null
     * @Assert\Image(
     *     maxSize = "5M",
     *     maxSizeMessage = "The maximum allowed file size is {{ limit }}",
     *     mimeTypes = {"image/png", "image/jpeg", "image/jpg", "image/gif"},
     *     mimeTypesMessage = "Please upload a valid image file"
     * )
     */
    private ?File $photoFile;



    #[Assert\Length(max: 255, maxMessage: "Phone number should not exceed {{ limit }} characters")]
    #[ORM\Column(name: 'numTel', type: 'string', length: 255, nullable: true)]
    private ?string $numtel;

    #[ORM\OneToMany(mappedBy: 'userid', targetEntity: 'App\Entity\Badge', cascade: ['persist'])]
    private Collection $badge;

    #[ORM\OneToMany(mappedBy: 'proprietaire', targetEntity: 'Offre', cascade: ['persist'])]
    private Collection $offre;

    #[ORM\Column(name: "isVerified", type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->offre = new ArrayCollection();
        $this->badge = new ArrayCollection();
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->motdepasse;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials()
    {
    }

    public function getSalt(): ?string
    {
        return null;
    }
    public function getPhotoFile(): string
    {
        return $this->photoFile;
    }

    public function setPhotoFile(File $photoFile): self
    {
        $this->photoFile = $photoFile;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->idUser;
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

    public function getBadge(): ArrayCollection
    {
        return $this->badge;
    }

    public function setBadge(ArrayCollection $badge): self
    {
        $this->badge = $badge;

        return $this;
    }

    public function getOffre(): ArrayCollection
    {
        return $this->offre;
    }

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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
