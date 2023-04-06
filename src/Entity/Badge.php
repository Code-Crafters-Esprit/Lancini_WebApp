<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BadgeRepository;

#[ORM\Entity(repositoryClass: BadgeRepository::class)]
class Badge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idBadge")]
    private ?int $idBadge = null;
    
    #[ORM\Column(length:255)]
    private ?string $nombadge = null;

    #[ORM\Column()]
    private ?\DateTime $date = null;

    
 
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "userId", referencedColumnName: "idUser")]
    private $userId;
   
  
    #[ORM\ManyToOne(targetEntity: Test::class)]
    #[ORM\JoinColumn(name: "testId", referencedColumnName: "idTest")]
    private $testId;

    public function getIdBadge(): ?int
    {
        return $this->idBadge;
    }

    public function getNombadge(): ?string
    {
        return $this->nombadge;
    }

    public function setNombadge(string $nombadge): self
    {
        $this->nombadge = $nombadge;

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

    public function getUserid(): ?User
    {
        return $this->userId;
    }

    public function setUserid(?User $userid): self
    {
        $this->userId = $userid;

        return $this;
    }

    public function getTestid(): ?Test
    {
        return $this->testId;
    }

    public function setTestid(?Test $testid): self
    {
        $this->testId = $testid;

        return $this;
    }


}
