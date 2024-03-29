<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuestionRepository;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{ #[ORM\Column(name: "id", type: "integer", nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    private $id;

    #[ORM\Column(name: "libelle", type: "string", length: 255, nullable: false)]
    private $libelle;

    #[ORM\ManyToOne(targetEntity: Test::class)]
    #[ORM\JoinColumn(name: "testId", referencedColumnName: "idTest")]
    private $testid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
