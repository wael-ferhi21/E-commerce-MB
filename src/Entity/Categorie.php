<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $catid = null;

    #[ORM\Column(length: 255)]
    private ?string $catlib = null;
    /**
     * @ORM\OneToMany(targetEntity="Produit", mappedBy="categorie")
     */
    private $produits;

    // ...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCatid(): ?int
    {
        return $this->catid;
    }

    public function setCatid(int $catid): self
    {
        $this->catid = $catid;

        return $this;
    }

    public function getCatlib(): ?string
    {
        return $this->catlib;
    }

    public function setCatlib(string $catlib): self
    {
        $this->catlib = $catlib;

        return $this;
    }
    
    /**
     * @return Collection<int, Produit>
     */
    public function getProducts(): Collection
    {
        return $this->produits;
    }
    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setCategorie($this);
        }

        return $this;
    }

    //public function removeProduct(Produit $produit): self
   // {
      //  if ($this->produits->removeElement($produit)) {
            
           // if ($produit->getCategorie() === $this) {
               // $produit->setCategorie();
           // }
       // }
       // return $this;
   // }

    public function __toString()
    {
        return $this->catlib;
    }

}
