<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="questionId", columns={"questionId"})})
 * @ORM\Entity
 */
class Reponse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="estVrai", type="boolean", nullable=true)
     */
    private $estvrai;

    /**
     * @var \Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="questionId", referencedColumnName="id")
     * })
     */
    private $questionid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function isEstvrai(): ?bool
    {
        return $this->estvrai;
    }

    public function setEstvrai(?bool $estvrai): self
    {
        $this->estvrai = $estvrai;

        return $this;
    }

    public function getQuestionid(): ?Question
    {
        return $this->questionid;
    }

    public function setQuestionid(?Question $questionid): self
    {
        $this->questionid = $questionid;

        return $this;
    }


}
