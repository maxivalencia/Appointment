<?php

namespace App\Entity;

use App\Repository\HistoriqueRendezVousRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueRendezVousRepository::class)]
class HistoriqueRendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $rendezVous = null;

    /**
     * @var Collection<int, RendezVous>
     */
    #[ORM\OneToMany(targetEntity: RendezVous::class, mappedBy: 'historiqueRendezVous')]
    private Collection $idRendezVous;

    public function __construct()
    {
        $this->idRendezVous = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRendezVous(): ?string
    {
        return strtoupper($this->rendezVous);
    }

    public function setRendezVous(?string $rendezVous): static
    {
        $this->rendezVous = strtoupper($rendezVous);

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getIdRendezVous(): Collection
    {
        return $this->idRendezVous;
    }

    public function addIdRendezVou(RendezVous $idRendezVou): static
    {
        if (!$this->idRendezVous->contains($idRendezVou)) {
            $this->idRendezVous->add($idRendezVou);
            $idRendezVou->setHistoriqueRendezVous($this);
        }

        return $this;
    }

    public function removeIdRendezVou(RendezVous $idRendezVou): static
    {
        if ($this->idRendezVous->removeElement($idRendezVou)) {
            // set the owning side to null (unless already changed)
            if ($idRendezVou->getHistoriqueRendezVous() === $this) {
                $idRendezVou->setHistoriqueRendezVous(null);
            }
        }

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString(): string
    {
        return strtoupper($this->getRendezVous());
    }
}
