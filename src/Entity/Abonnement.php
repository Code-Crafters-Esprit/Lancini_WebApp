<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement", indexes={@ORM\Index(name="userIdFollowed", columns={"userIdFollowed"}), @ORM\Index(name="userId", columns={"userId"})})
 * @ORM\Entity
 */
class Abonnement
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAbonnement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idabonnement;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userIdFollowed", referencedColumnName="idUser")
     * })
     */
    private $useridfollowed;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userId", referencedColumnName="idUser")
     * })
     */
    private $userid;

    public function getIdabonnement(): ?int
    {
        return $this->idabonnement;
    }

    public function getUseridfollowed(): ?User
    {
        return $this->useridfollowed;
    }

    public function setUseridfollowed(?User $useridfollowed): self
    {
        $this->useridfollowed = $useridfollowed;

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


}
