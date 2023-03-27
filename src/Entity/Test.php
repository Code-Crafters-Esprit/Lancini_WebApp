<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'test')]
#[ORM\Entity]
class Test
{
    /**
     * @var int
     */
    #[ORM\Column(name: 'idTest', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $idtest;

    /**
     * @var string
     */
    #[ORM\Column(name: 'nomTest', type: 'string', length: 255, nullable: false)]
    private $nomtest;

    /**
     * @var int
     */
    #[ORM\Column(name: 'difficulte', type: 'integer', nullable: false)]
    private $difficulte;

    public function getIdtest(): ?int
    {
        return $this->idtest;
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
