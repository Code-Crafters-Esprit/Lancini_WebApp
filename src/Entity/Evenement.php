<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;
use App\Repository\EvenementRepository;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\Date;
use App\Validator\Constraints\EventParticipantCount;


#[ORM\Entity(repositoryClass: EvenementRepository::class)]


 
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column (name :"idevent")]
    private ?int $idevent = null;

    #[ORM\Column(length:30)]
    #[Assert\NotBlank(message:"Please fill out the title field")]
    #[Assert\Length(max: 30)]
    private ?string $titre = null;

    #[ORM\Column(length:100)]
    #[Assert\NotBlank(message:"Please fill out the subject field")]
    #[Assert\Length(max: 100)]
    private ?string $sujet = null;
    
    #[ORM\Column(length:50)]
    #[Assert\NotBlank(message:"Please fill out the place field")]
    #[Assert\Length(max: 50)]
    private ?string $lieu = null;

    #[ORM\Column(length:10)]
    #[Assert\NotBlank(message:"Please fill out the time field")]
    #[Assert\Length(max: 10)]
    private ?string $horaire = null;
    
    #[ORM\Column(name: "dateEvent", type: "date", length: 100, nullable: false)]
    #[Assert\NotBlank(message:"Please fill out the date field")]
    private $dateevent ;
   
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'proprietaire', referencedColumnName: 'idUser', nullable: true)]
    private ?User $proprietaire = null; 

    #[ORM\OneToMany(mappedBy: 'idevent', targetEntity: Participants::class)]
    private $participants;
    

    public function getIdevent(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getHoraire(): ?string
    {
        return $this->horaire;
    }

    public function setHoraire(string $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    public function getDateevent(): ?string
    {
        if ($this->dateevent instanceof \DateTimeInterface) {
            return $this->dateevent->format('d/m/Y');
        }
        return null;
    }

    public function setDateevent(DateTime $dateevent): self
    {
        $this->dateevent = $dateevent;

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

    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function countParticipants(): int
{
    return count($this->participants);
}

    

}
