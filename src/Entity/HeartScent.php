<?php

namespace App\Entity;

use App\Repository\HeartScentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeartScentRepository::class)]
class HeartScent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'heartScent', targetEntity: CreatedPerfume::class, orphanRemoval: true)]
    private Collection $CreatedPerfume;

    #[ORM\Column(length: 255)]
    private ?string $scent = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function __construct()
    {
        $this->CreatedPerfume = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->scent;
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
            $createdPerfume->setHeartScent($this);
        }

        return $this;
    }

    public function removeCreatedPerfume(CreatedPerfume $createdPerfume): self
    {
        if ($this->CreatedPerfume->removeElement($createdPerfume)) {
            // set the owning side to null (unless already changed)
            if ($createdPerfume->getHeartScent() === $this) {
                $createdPerfume->setHeartScent(null);
            }
        }

        return $this;
    }

    public function getScent(): ?string
    {
        return $this->scent;
    }

    public function setScent(string $scent): self
    {
        $this->scent = $scent;

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
