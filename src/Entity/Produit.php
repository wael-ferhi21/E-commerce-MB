<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?float $qtestock = null;

    #[ORM\Column]
    private ?float $tauxtva = null;

    #[ORM\Column]
    private ?float $tauxremise = null;

    #[ORM\Column(length: 255)]
    private ?string $proddescr = null;

    #[ORM\Column(length: 255)]
    private ?string $alert_stock = null;
  

    #[ORM\Column(length: 255)]
    private ?string $prod_name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;


    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Categorie $categorie = null;

    // ...


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQtestock(): ?float
    {
        return $this->qtestock;
    }

    public function setQtestock(float $qtestock): self
    {
        $this->qtestock = $qtestock;

        return $this;
    }

    public function getTauxtva(): ?float
    {
        return $this->tauxtva;
    }

    public function setTauxtva(float $tauxtva): self
    {
        $this->tauxtva = $tauxtva;

        return $this;
    }

    public function getTauxremise(): ?float
    {
        return $this->tauxremise;
    }

    public function setTauxremise(float $tauxremise): self
    {
        $this->tauxremise = $tauxremise;

        return $this;
    }

    public function getProddescr(): ?string
    {
        return $this->proddescr;
    }

    public function setProddescr(string $proddescr): self
    {
        $this->proddescr = $proddescr;

        return $this;
    }

    public function getAlertStock(): ?string
    {
        return $this->alert_stock;
    }

    public function setAlertStock(string $alert_stock): self
    {
        $this->alert_stock = $alert_stock;

        return $this;
    }
 
    public function getProdName(): ?string
    {
        return $this->prod_name;
    }

    public function setProdName(string $prod_name): self
    {
        $this->prod_name = $prod_name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
