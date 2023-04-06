<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TestRepository;


#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idTest")]
    private ?int $idTest = null;

    #[ORM\Column(length: 255)]
    private ?string $nomtest = null;


    #[ORM\Column]
    private ?int $difficulte = null;


    public function getIdtest(): ?int
    {
        return $this->idTest;
    }

    public function getNomtest(): ?string
    {
        return $this->nomtest;
    }

    public function setNomtest(string $nomtest): self
    {
        $this->nomtest = $nomtest;

        return $this;
    }

    public function getDifficulte(): ?int
    {
        return $this->difficulte;
    }

    public function setDifficulte(int $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }
}
