<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datefact = null;

    #[ORM\Column]
    private ?float $tva = null;

    #[ORM\Column]
    private ?float $remise = null;

    #[ORM\Column]
    private ?float $totaleht = null;

    #[ORM\Column]
    private ?float $totalettc = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatefact(): ?\DateTimeInterface
    {
        return $this->datefact;
    }

    public function setDatefact(\DateTimeInterface $datefact): self
    {
        $this->datefact = $datefact;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getRemise(): ?float
    {
        return $this->remise;
    }

    public function setRemise(float $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getTotaleht(): ?float
    {
        return $this->totaleht;
    }

    public function setTotaleht(float $totaleht): self
    {
        $this->totaleht = $totaleht;

        return $this;
    }

    public function getTotalettc(): ?float
    {
        return $this->totalettc;
    }

    public function setTotalettc(float $totalettc): self
    {
        $this->totalettc = $totalettc;

        return $this;
    }
}
