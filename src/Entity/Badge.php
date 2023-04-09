<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Badge
 */
#[ORM\Table(name: 'badge')]
#[ORM\Index(columns: ['userId'], name: 'userId')]
#[ORM\Index(columns: ['testId'], name: 'testId')]
#[ORM\Entity]
class Badge
{
    #[ORM\Column(name: 'idBadge', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private int $idbadge;

    #[ORM\Column(name: 'nomBadge', type: 'string', length: 255, nullable: false)]
    private string $nombadge;

    #[ORM\Column(name: 'date', type: 'date', nullable: false)]
    private \DateTime $date;

    #[ORM\JoinColumn(name: 'userId', referencedColumnName: 'idUser')]
    #[ORM\ManyToOne(targetEntity: 'User')]
    private ?User $userid;

    #[ORM\JoinColumn(name: 'testId', referencedColumnName: 'idTest')]
    #[ORM\ManyToOne(targetEntity: 'Test')]
    private ?Test $testid;

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
