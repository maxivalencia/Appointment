<?php

namespace App\Entity;

use App\Repository\ProvincesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProvincesRepository::class)]
class Provinces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $province = null;

    /**
     * @var Collection<int, Centres>
     */
    #[ORM\OneToMany(targetEntity: Centres::class, mappedBy: 'province')]
    private Collection $centres;

    public function __construct()
    {
        $this->centres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(string $province): static
    {
        $this->province = $province;

        return $this;
    }

    /**
     * @return Collection<int, Centres>
     */
    public function getCentres(): Collection
    {
        return $this->centres;
    }

    public function addCentre(Centres $centre): static
    {
        if (!$this->centres->contains($centre)) {
            $this->centres->add($centre);
            $centre->setProvince($this);
        }

        return $this;
    }

    public function removeCentre(Centres $centre): static
    {
        if ($this->centres->removeElement($centre)) {
            // set the owning side to null (unless already changed)
            if ($centre->getProvince() === $this) {
                $centre->setProvince(null);
            }
        }

        return $this;
    }
}
