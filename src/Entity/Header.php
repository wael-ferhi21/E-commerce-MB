<?php

namespace App\Entity;

use App\Repository\HeaderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeaderRepository::class)]
class Header
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $btnTitre = null;

    #[ORM\Column(length: 255)]
    private ?string $btnUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getBtnTitre(): ?string
    {
        return $this->btnTitre;
    }

    public function setBtnTitre(string $btnTitre): self
    {
        $this->btnTitre = $btnTitre;

        return $this;
    }

    public function getBtnUrl(): ?string
    {
        return $this->btnUrl;
    }

    public function setBtnUrl(string $btnUrl): self
    {
        $this->btnUrl = $btnUrl;

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
}
