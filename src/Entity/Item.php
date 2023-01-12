<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: CreatedPerfume::class, orphanRemoval: true)]
    private Collection $CreatedPerfume;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\OneToMany(mappedBy: 'Item', targetEntity: ReproducedPerfume::class, orphanRemoval: true)]
    private Collection $ReproducedPerfume;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function __construct()
    {
        $this->CreatedPerfume = new ArrayCollection();
        $this->ReproducedPerfume = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $createdPerfume->setItem($this);
        }

        return $this;
    }

    public function removeCreatedPerfume(CreatedPerfume $createdPerfume): self
    {
        if ($this->CreatedPerfume->removeElement($createdPerfume)) {
            // set the owning side to null (unless already changed)
            if ($createdPerfume->getItem() === $this) {
                $createdPerfume->setItem(null);
            }
        }

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

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
            $reproducedPerfume->setItem($this);
        }

        return $this;
    }

    public function removeReproducedPerfume(ReproducedPerfume $reproducedPerfume): self
    {
        if ($this->ReproducedPerfume->removeElement($reproducedPerfume)) {
            // set the owning side to null (unless already changed)
            if ($reproducedPerfume->getItem() === $this) {
                $reproducedPerfume->setItem(null);
            }
        }

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
}
