<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;

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
}
