<?php

namespace App\Entity;

use App\Repository\NombreModificationMaximumRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NombreModificationMaximumRepository::class)]
class NombreModificationMaximum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombreModification = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateApplication = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreModification(): ?int
    {
        return $this->nombreModification;
    }

    public function setNombreModification(int $nombreModification): static
    {
        $this->nombreModification = $nombreModification;

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
        return $this->getNombreModification();
    }
}
