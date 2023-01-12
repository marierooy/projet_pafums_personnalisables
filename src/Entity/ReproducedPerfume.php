<?php

namespace App\Entity;

use App\Repository\ReproducedPerfumeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReproducedPerfumeRepository::class)]
class ReproducedPerfume
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $samplingPrice = null;

    #[ORM\ManyToOne(inversedBy: 'ReproducedPerfume')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Item $item = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSamplingPrice(): ?string
    {
        return $this->samplingPrice;
    }

    public function setSamplingPrice(string $samplingPrice): self
    {
        $this->samplingPrice = $samplingPrice;

        return $this;
    }

    public function getItem(): ?string
    {
        return $this->item;
    }

    public function setItem(string $item): self
    {
        $this->item = $item;

        return $this;
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
}
