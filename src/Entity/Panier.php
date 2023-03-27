<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $p_id = null;

    #[ORM\Column]
    private ?float $prixtotal = null;

    #[ORM\Column]
    private ?int $nbr_prod = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPId(): ?int
    {
        return $this->p_id;
    }

    public function setPId(int $p_id): self
    {
        $this->p_id = $p_id;

        return $this;
    }

    public function getPrixtotal(): ?float
    {
        return $this->prixtotal;
    }

    public function setPrixtotal(float $prixtotal): self
    {
        $this->prixtotal = $prixtotal;

        return $this;
    }

    public function getNbrProd(): ?int
    {
        return $this->nbr_prod;
    }

    public function setNbrProd(int $nbr_prod): self
    {
        $this->nbr_prod = $nbr_prod;

        return $this;
    }
}
