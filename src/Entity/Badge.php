<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Badge
 *
 * @ORM\Table(name="badge", indexes={@ORM\Index(name="userId", columns={"userId"}), @ORM\Index(name="testId", columns={"testId"})})
 * @ORM\Entity
 */
class Badge
{
    /**
     * @var int
     *
     * @ORM\Column(name="idBadge", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idbadge;

    /**
     * @var string
     *
     * @ORM\Column(name="nomBadge", type="string", length=255, nullable=false)
     */
    private $nombadge;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userId", referencedColumnName="idUser")
     * })
     */
    private $userid;

    /**
     * @var \Test
     *
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="testId", referencedColumnName="idTest")
     * })
     */
    private $testid;

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
