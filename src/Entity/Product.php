<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToMany(targetEntity: CreatedPerfume::class, inversedBy: 'products')]
    private Collection $CreatedPerfume;

    #[ORM\ManyToMany(targetEntity: ReproducedPerfume::class, inversedBy: 'products')]
    private Collection $ReproducedPerfume;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    public function __construct()
    {
        $this->CreatedPerfume = new ArrayCollection();
        $this->ReproducedPerfume = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, CreatedPerfume>
     */
    public function getCreatedPerfume(): Collection
    {
        return $this->CreatedPerfume;
    }

    public function addCreatedPerfume(CreatedPerfume $createdPerfume): self
    {
        if (!$this->CreatedPerfume->contains($createdPerfume)) {
            $this->CreatedPerfume->add($createdPerfume);
        }

        return $this;
    }

    public function removeCreatedPerfume(CreatedPerfume $createdPerfume): self
    {
        $this->CreatedPerfume->removeElement($createdPerfume);

        return $this;
    }

    /**
     * @return Collection<int, ReproducedPerfume>
     */
    public function getReproducedPerfume(): Collection
    {
        return $this->ReproducedPerfume;
    }

    public function addReproducedPerfume(ReproducedPerfume $reproducedPerfume): self
    {
        if (!$this->ReproducedPerfume->contains($reproducedPerfume)) {
            $this->ReproducedPerfume->add($reproducedPerfume);
        }

        return $this;
    }

    public function removeReproducedPerfume(ReproducedPerfume $reproducedPerfume): self
    {
        $this->ReproducedPerfume->removeElement($reproducedPerfume);

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
