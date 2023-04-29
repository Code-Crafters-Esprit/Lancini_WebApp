<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomtest = null;

    #[ORM\Column]
    private ?int $difficulte = null;

    #[ORM\ManyToMany(targetEntity: Quiz::class, inversedBy: 'tests')]
    private Collection $quizzes;

    public function __construct()
    {
        $this->quizzes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function __toString(): string {
        return $this->nomtest;
    }

    /**
     * @return Collection<int, Quiz>
     */
    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes->add($quiz);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        $this->quizzes->removeElement($quiz);

        return $this;
    }
}
