<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $comdid = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $comddate = null;

    #[ORM\Column(length: 255)]
    private ?string $comddescr = null;

    #[ORM\Column(length: 255)]
    private ?string $aadresse_client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComdid(): ?int
    {
        return $this->comdid;
    }

    public function setComdid(int $comdid): self
    {
        $this->comdid = $comdid;

        return $this;
    }

    public function getComddate(): ?\DateTimeInterface
    {
        return $this->comddate;
    }

    public function setComddate(\DateTimeInterface $comddate): self
    {
        $this->comddate = $comddate;

        return $this;
    }

    public function getComddescr(): ?string
    {
        return $this->comddescr;
    }

    public function setComddescr(string $comddescr): self
    {
        $this->comddescr = $comddescr;

        return $this;
    }

    public function getAadresseClient(): ?string
    {
        return $this->aadresse_client;
    }

    public function setAadresseClient(string $aadresse_client): self
    {
        $this->aadresse_client = $aadresse_client;

        return $this;
    }
}
