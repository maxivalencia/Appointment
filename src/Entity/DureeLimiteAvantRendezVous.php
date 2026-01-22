<?php

namespace App\Entity;

use App\Repository\DureeLimiteAvantRendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DureeLimiteAvantRendezVousRepository::class)]
class DureeLimiteAvantRendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $nombreHeure = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateApplication = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreHeure(): ?\DateTime
    {
        return $this->nombreHeure;
    }

    public function setNombreHeure(\DateTime $nombreHeure): static
    {
        $this->nombreHeure = $nombreHeure;

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
        return strtoupper($this->getNombreHeure()->format('d/m/Y H:i:s'));
    }
}
