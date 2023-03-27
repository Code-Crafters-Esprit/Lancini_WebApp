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
    #[ORM\Column]
    private ?int $idbadge = null;
    
    #[ORM\Column(length:255)]
    private ?string $nombadge = null;

    #[ORM\Column()]
    private ?\DateTime $date = null;

    
    #[ORM\ManyToOne(targetEntity: "User", inversedBy: 'Badge')]
    private ?User $userid = null;

   
    #[ORM\ManyToOne(targetEntity: "Test", inversedBy: 'Badge')]
    private ?Test $testid = null;


    public function getIdbadge(): ?int
    {
        return $this->idbadge;
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
        return $this->userid;
    }

    public function setUserid(?User $userid): self
    {
        $this->userid = $userid;

        return $this;
    }

    public function getTestid(): ?Test
    {
        return $this->testid;
    }

    public function setTestid(?Test $testid): self
    {
        $this->testid = $testid;

        return $this;
    }


}
