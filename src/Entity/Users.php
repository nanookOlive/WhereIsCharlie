<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?float $longitude = null;

    #[ORM\Column]
    #[Assert\NotNull]
    private ?float $latitude = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    private ?string $city = null;

    #[ORM\Column(length: 500)]
    #[Assert\NotNull]
    private ?string $addrees = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getAddrees(): ?string
    {
        return $this->addrees;
    }

    public function setAddrees(string $addrees): static
    {
        $this->addrees = $addrees;

        return $this;
    }
}
