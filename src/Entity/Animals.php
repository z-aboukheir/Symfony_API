<?php

namespace App\Entity;

use App\Repository\AnimalsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalsRepository::class)]
class Animals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $averageSize = null;


    #[ORM\Column]
    private ?int $averageLife = null;

    #[ORM\Column(length: 255)]
    private ?string $martialArt = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAverageSize(): ?int
    {
        return $this->averageSize;
    }

    public function setAverageSize(int $averageSize): self
    {
        $this->averageSize = $averageSize;

        return $this;
    }


    public function getAverageLife(): ?int
    {
        return $this->averageLife;
    }

    public function setAverageLife(int $averageLife): self
    {
        $this->averageLife = $averageLife;

        return $this;
    }

    public function getMartialArt(): ?string
    {
        return $this->martialArt;
    }

    public function setMartialArt(string $martialArt): self
    {
        $this->martialArt = $martialArt;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }
}
