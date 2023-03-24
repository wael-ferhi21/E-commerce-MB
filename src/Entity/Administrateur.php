<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministrateurRepository::class)]
/**
 * @ORM\Entity
 * @ORM\Table(name="administrateur")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"administrateur" = "Administratteur"})
 */
class Administrateur extends Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
