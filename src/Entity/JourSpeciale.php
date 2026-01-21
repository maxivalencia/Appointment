<?php

namespace App\Entity;

use App\Repository\JourSpecialeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JourSpecialeRepository::class)]
class JourSpeciale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateSpeciale = null;

    #[ORM\Column(nullable: true)]
    private ?bool $ouvrable = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $heureDebut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $heureFin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSpeciale(): ?\DateTime
    {
        return $this->dateSpeciale;
    }

    public function setDateSpeciale(\DateTime $dateSpeciale): static
    {
        $this->dateSpeciale = $dateSpeciale;

        return $this;
    }

    public function isOuvrable(): ?bool
    {
        return $this->ouvrable;
    }

    public function setOuvrable(bool $ouvrable): static
    {
        $this->ouvrable = $ouvrable;

        return $this;
    }

    public function getHeureDebut(): ?\DateTime
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTime $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTime
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTime $heureFin): static
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString(): string
    {
        return $this->getDateSpeciale()->format('d/m/Y H:i:s');
    }
}
