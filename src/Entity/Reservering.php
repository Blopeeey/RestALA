<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReserveringRepository")
 */
class Reservering
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datum;

    /**
     * @ORM\Column(type="time")
     */
    private $start_tijd;

    /**
     * @ORM\Column(type="time")
     */
    private $eind_tijd;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $klant_naam;

    /**
     * @ORM\Column(type="integer")
     */
    private $klant_nummer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Medewerker")
     * @ORM\JoinColumn(nullable=false)
     */
    private $medewerker;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tafel")
     */
    private $reservering_tafel;

    public function __construct()
    {
        $this->reservering_tafel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }

    public function getStartTijd(): ?\DateTimeInterface
    {
        return $this->start_tijd;
    }

    public function setStartTijd(\DateTimeInterface $start_tijd): self
    {
        $this->start_tijd = $start_tijd;

        return $this;
    }

    public function getEindTijd(): ?\DateTimeInterface
    {
        return $this->eind_tijd;
    }

    public function setEindTijd(\DateTimeInterface $eind_tijd): self
    {
        $this->eind_tijd = $eind_tijd;

        return $this;
    }

    public function getKlantNaam(): ?string
    {
        return $this->klant_naam;
    }

    public function setKlantNaam(string $klant_naam): self
    {
        $this->klant_naam = $klant_naam;

        return $this;
    }

    public function getKlantNummer(): ?int
    {
        return $this->klant_nummer;
    }

    public function setKlantNummer(int $klant_nummer): self
    {
        $this->klant_nummer = $klant_nummer;

        return $this;
    }

    public function getMedewerker(): ?Medewerker
    {
        return $this->medewerker;
    }

    public function setMedewerker(?Medewerker $medewerker): self
    {
        $this->medewerker = $medewerker;

        return $this;
    }

    /**
     * @return Collection|Tafel[]
     */
    public function getReserveringTafel(): Collection
    {
        return $this->reservering_tafel;
    }

    public function addReserveringTafel(Tafel $reserveringTafel): self
    {
        if (!$this->reservering_tafel->contains($reserveringTafel)) {
            $this->reservering_tafel[] = $reserveringTafel;
        }

        return $this;
    }

    public function removeReserveringTafel(Tafel $reserveringTafel): self
    {
        if ($this->reservering_tafel->contains($reserveringTafel)) {
            $this->reservering_tafel->removeElement($reserveringTafel);
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }
}
