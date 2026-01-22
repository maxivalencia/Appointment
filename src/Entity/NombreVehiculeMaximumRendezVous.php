<?php

namespace App\Entity;

use App\Repository\NombreVehiculeMaximumRendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NombreVehiculeMaximumRendezVousRepository::class)]
class NombreVehiculeMaximumRendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombreVehicule = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateApplication = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreVehicule(): ?int
    {
        return $this->nombreVehicule;
    }

    public function setNombreVehicule(int $nombreVehicule): static
    {
        $this->nombreVehicule = $nombreVehicule;

        return $this;
    }

    public function getDateApplication(): ?\DateTime
    {
        return $this->dateApplication;
    }

    public function setDateApplication(\DateTime $dateApplication): static
    {
        $this->dateApplication = $dateApplication;

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString(): string
    {
        return strtoupper($this->getNombreVehicule());
    }
}
