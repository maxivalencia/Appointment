<?php

namespace App\Entity;

use App\Repository\NombreRendezVousParHeureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NombreRendezVousParHeureRepository::class)]
class NombreRendezVousParHeure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombreRendezVous = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dataApplication = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreRendezVous(): ?int
    {
        return $this->nombreRendezVous;
    }

    public function setNombreRendezVous(int $nombreRendezVous): static
    {
        $this->nombreRendezVous = $nombreRendezVous;

        return $this;
    }

    public function getDataApplication(): ?\DateTime
    {
        return $this->dataApplication;
    }

    public function setDataApplication(\DateTime $dataApplication): static
    {
        $this->dataApplication = $dataApplication;

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString(): string
    {
        return $this->getNombreRendezVous();
    }
}
