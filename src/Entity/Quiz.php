<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quiz
 *
 * @ORM\Table(name="quiz", indexes={@ORM\Index(name="idTest", columns={"idTest"})})
 * @ORM\Entity
 */
class Quiz
{
    /**
     * @var int
     *
     * @ORM\Column(name="idQuiz", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idquiz;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="string", length=255, nullable=false)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="reponseCorrecte", type="string", length=255, nullable=false)
     */
    private $reponsecorrecte;

    /**
     * @var string
     *
     * @ORM\Column(name="reponseFausse1", type="string", length=255, nullable=false)
     */
    private $reponsefausse1;

    /**
     * @var string
     *
     * @ORM\Column(name="reponseFausse2", type="string", length=255, nullable=false)
     */
    private $reponsefausse2;

    /**
     * @var string
     *
     * @ORM\Column(name="reponseFausse3", type="string", length=255, nullable=false)
     */
    private $reponsefausse3;

    /**
     * @var \Test
     *
     * @ORM\ManyToOne(targetEntity="Test")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTest", referencedColumnName="idTest")
     * })
     */
    private $idtest;

    public function getIdquiz(): ?int
    {
        return $this->idquiz;
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

    public function getIdtest(): ?Test
    {
        return $this->idtest;
    }

    public function setIdtest(?Test $idtest): self
    {
        $this->idtest = $idtest;

        return $this;
    }


}
