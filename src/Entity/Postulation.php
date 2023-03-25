<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postulation
 *
 * @ORM\Table(name="postulation", indexes={@ORM\Index(name="idUser", columns={"idUser", "idOffre"}), @ORM\Index(name="idOffre", columns={"idOffre", "idUser"}), @ORM\Index(name="IDX_DA7D4E9BB842C572", columns={"idOffre"}), @ORM\Index(name="IDX_DA7D4E9BFE6E88D7", columns={"idUser"})})
 * @ORM\Entity
 */
class Postulation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPost", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpost;

    /**
     * @var \Offre
     *
     * @ORM\ManyToOne(targetEntity="Offre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idOffre", referencedColumnName="idOffre")
     * })
     */
    private $idoffre;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="idUser")
     * })
     */
    private $iduser;

    public function getIdpost(): ?int
    {
        return $this->idpost;
    }

    public function getIdoffre(): ?Offre
    {
        return $this->idoffre;
    }

    public function setIdoffre(?Offre $idoffre): self
    {
        $this->idoffre = $idoffre;

        return $this;
    }

    public function getIduser(): ?User
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
