<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $commandeclient = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $carrierNom = null;

    #[ORM\Column]
    private ?float $carrierPrix = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $adrlivraison = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeDetails::class)]
    private Collection $commandeDetails;


    #[ORM\Column]
    private ?int $state = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    public function __construct()
    {
        $this->commandeDetails = new ArrayCollection();
    }
    public function getTotal(){
        $total= null ; 
        foreach ($this->getCommandeDetails()->getValues() as $produit ) {
         $total=$total + ($produit->getPrix() * $produit->getQuantite());
        }
        return $total;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommandeclient(): ?Utilisateur
    {
        return $this->commandeclient;
    }

    public function setCommandeclient(?Utilisateur $commandeclient): self
    {
        $this->commandeclient = $commandeclient;

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

    public function getCarrierNom(): ?string
    {
        return $this->carrierNom;
    }

    public function setCarrierNom(string $carrierNom): self
    {
        $this->carrierNom = $carrierNom;

        return $this;
    }

    public function getCarrierPrix(): ?float
    {
        return $this->carrierPrix;
    }

    public function setCarrierPrix(float $carrierPrix): self
    {
        $this->carrierPrix = $carrierPrix;

        return $this;
    }

    public function getAdrlivraison(): ?string
    {
        return $this->adrlivraison;
    }

    public function setAdrlivraison(string $adrlivraison): self
    {
        $this->adrlivraison = $adrlivraison;

        return $this;
    }

    /**
     * @return Collection<int, CommandeDetails>
     */
    public function getCommandeDetails(): Collection
    {
        return $this->commandeDetails;
    }

    public function addCommandeDetail(CommandeDetails $commandeDetail): self
    {
        if (!$this->commandeDetails->contains($commandeDetail)) {
            $this->commandeDetails->add($commandeDetail);
            $commandeDetail->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeDetail(CommandeDetails $commandeDetail): self
    {
        if ($this->commandeDetails->removeElement($commandeDetail)) {
            // set the owning side to null (unless already changed)
            if ($commandeDetail->getCommande() === $this) {
                $commandeDetail->setCommande(null);
            }
        }

        return $this;
    }


    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }
}
