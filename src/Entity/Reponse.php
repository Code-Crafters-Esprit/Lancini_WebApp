<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReponseRepository;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]

class Reponse
{  #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $libelle;

    #[ORM\Column(type: "boolean", nullable: true)]
    private $estvrai;

    #[ORM\ManyToOne(targetEntity: Question::class)]
    #[ORM\JoinColumn(name: "questionId", referencedColumnName: "id")]
    private $questionId;
   
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
        return $this->questionId;
    }

    public function setQuestionid(?Question $questionid): self
    {
        $this->questionId = $questionid;

        return $this;
    }


}
