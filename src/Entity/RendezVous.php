<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $immatriculation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $proprietaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $datePriseRendezVous = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $dateRendezVous = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $heureRendezVous = null;

    #[ORM\Column(nullable: true)]
    private ?bool $confirmation = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateHeureArriveRendezVous = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateHeureFinVisite = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateHeureDebutVisite = null;

    #[ORM\Column(nullable: true)]
    private ?bool $annulationRendezVous = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateHeureAnnulationRendezVous = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeRendezVous = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateModificationRendezVous = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $dateOrigineRendezVous = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombreModification = null;

    #[ORM\ManyToOne(inversedBy: 'idRendezVous')]
    private ?HistoriqueRendezVous $historiqueRendezVous = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(?string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getProprietaire(): ?string
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?string $proprietaire): static
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDatePriseRendezVous(): ?\DateTime
    {
        return $this->datePriseRendezVous;
    }

    public function setDatePriseRendezVous(?\DateTime $datePriseRendezVous): static
    {
        $this->datePriseRendezVous = $datePriseRendezVous;

        return $this;
    }

    public function getDateRendezVous(): ?\DateTime
    {
        return $this->dateRendezVous;
    }

    public function setDateRendezVous(?\DateTime $dateRendezVous): static
    {
        $this->dateRendezVous = $dateRendezVous;

        return $this;
    }

    public function getHeureRendezVous(): ?\DateTime
    {
        return $this->heureRendezVous;
    }

    public function setHeureRendezVous(?\DateTime $heureRendezVous): static
    {
        $this->heureRendezVous = $heureRendezVous;

        return $this;
    }

    public function isConfirmation(): ?bool
    {
        return $this->confirmation;
    }

    public function setConfirmation(?bool $confirmation): static
    {
        $this->confirmation = $confirmation;

        return $this;
    }

    public function getDateHeureArriveRendezVous(): ?\DateTime
    {
        return $this->dateHeureArriveRendezVous;
    }

    public function setDateHeureArriveRendezVous(?\DateTime $dateHeureArriveRendezVous): static
    {
        $this->dateHeureArriveRendezVous = $dateHeureArriveRendezVous;

        return $this;
    }

    public function getDateHeureFinVisite(): ?\DateTime
    {
        return $this->dateHeureFinVisite;
    }

    public function setDateHeureFinVisite(?\DateTime $dateHeureFinVisite): static
    {
        $this->dateHeureFinVisite = $dateHeureFinVisite;

        return $this;
    }

    public function getDateHeureDebutVisite(): ?\DateTime
    {
        return $this->dateHeureDebutVisite;
    }

    public function setDateHeureDebutVisite(?\DateTime $dateHeureDebutVisite): static
    {
        $this->dateHeureDebutVisite = $dateHeureDebutVisite;

        return $this;
    }

    public function isAnnulationRendezVous(): ?bool
    {
        return $this->annulationRendezVous;
    }

    public function setAnnulationRendezVous(?bool $annulationRendezVous): static
    {
        $this->annulationRendezVous = $annulationRendezVous;

        return $this;
    }

    public function getDateHeureAnnulationRendezVous(): ?\DateTime
    {
        return $this->dateHeureAnnulationRendezVous;
    }

    public function setDateHeureAnnulationRendezVous(?\DateTime $dateHeureAnnulationRendezVous): static
    {
        $this->dateHeureAnnulationRendezVous = $dateHeureAnnulationRendezVous;

        return $this;
    }

    public function getCodeRendezVous(): ?string
    {
        return $this->codeRendezVous;
    }

    public function setCodeRendezVous(?string $codeRendezVous): static
    {
        $this->codeRendezVous = $codeRendezVous;

        return $this;
    }

    public function getDateModificationRendezVous(): ?\DateTime
    {
        return $this->dateModificationRendezVous;
    }

    public function setDateModificationRendezVous(?\DateTime $dateModificationRendezVous): static
    {
        $this->dateModificationRendezVous = $dateModificationRendezVous;

        return $this;
    }

    public function getDateOrigineRendezVous(): ?\DateTime
    {
        return $this->dateOrigineRendezVous;
    }

    public function setDateOrigineRendezVous(?\DateTime $dateOrigineRendezVous): static
    {
        $this->dateOrigineRendezVous = $dateOrigineRendezVous;

        return $this;
    }

    public function getNombreModification(): ?int
    {
        return $this->nombreModification;
    }

    public function setNombreModification(?int $nombreModification): static
    {
        $this->nombreModification = $nombreModification;

        return $this;
    }

    public function getHistoriqueRendezVous(): ?HistoriqueRendezVous
    {
        return $this->historiqueRendezVous;
    }

    public function setHistoriqueRendezVous(?HistoriqueRendezVous $historiqueRendezVous): static
    {
        $this->historiqueRendezVous = $historiqueRendezVous;

        return $this;
    }
}
