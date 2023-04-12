<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(length: 255)]
    private ?string $reponsecorrecte = null;

    #[ORM\Column(length: 255)]
    private ?string $reponsefausse1 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponsefausse2 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponsefausse3 = null;

    #[ORM\ManyToMany(targetEntity: Test::class, mappedBy: 'quizzes')]
    private Collection $tests;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getReponsecorrecte(): ?string
    {
        return $this->reponsecorrecte;
    }

    public function setReponsecorrecte(string $reponsecorrecte): self
    {
        $this->reponsecorrecte = $reponsecorrecte;

        return $this;
    }

    public function getReponsefausse1(): ?string
    {
        return $this->reponsefausse1;
    }

    public function setReponsefausse1(string $reponsefausse1): self
    {
        $this->reponsefausse1 = $reponsefausse1;

        return $this;
    }

    public function getReponsefausse2(): ?string
    {
        return $this->reponsefausse2;
    }

    public function setReponsefausse2(string $reponsefausse2): self
    {
        $this->reponsefausse2 = $reponsefausse2;

        return $this;
    }

    public function getReponsefausse3(): ?string
    {
        return $this->reponsefausse3;
    }

    public function setReponsefausse3(string $reponsefausse3): self
    {
        $this->reponsefausse3 = $reponsefausse3;

        return $this;
    }

    public function __toString(): string {
        return $this->question;
    }

    /**
     * @return Collection<int, Test>
     */
    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): self
    {
        if (!$this->tests->contains($test)) {
            $this->tests->add($test);
            $test->addQuiz($this);
        }

        return $this;
    }

    public function removeTest(Test $test): self
    {
        if ($this->tests->removeElement($test)) {
            $test->removeQuiz($this);
        }

        return $this;
    }
}
