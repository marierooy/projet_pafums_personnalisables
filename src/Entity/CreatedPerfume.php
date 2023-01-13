<?php

namespace App\Entity;

use App\Repository\CreatedPerfumeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreatedPerfumeRepository::class)]
class CreatedPerfume
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $proportionHeadScent = null;

    #[ORM\Column(length: 255)]
    private ?string $proportionHeartScent = null;

    #[ORM\Column(length: 255)]
    private ?string $proportionBaseScent = null;

    #[ORM\Column(length: 255)]
    private ?string $samplingPrice = null;

    #[ORM\Column(type: 'boolean', nullable: false, options:['default' => 0])]
    private ?bool $samplingValidation = null;

    #[ORM\ManyToOne(inversedBy: 'CreatedPerfume')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HeadScent $headScent = null;

    #[ORM\ManyToOne(inversedBy: 'CreatedPerfume')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HeartScent $heartScent = null;

    #[ORM\ManyToOne(inversedBy: 'CreatedPerfume')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BaseScent $baseScent = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'CreatedPerfume')]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeadScent(): ?HeadScent
    {
        return $this->headScent;
    }

    public function setHeadScent(HeadScent $headScent): self
    {
        $this->headScent = $headScent;

        return $this;
    }

    public function getProportionHeadScent(): ?string
    {
        return $this->proportionHeadScent;
    }

    public function setProportionHeadScent(string $proportionHeadScent): self
    {
        $this->proportionHeadScent = $proportionHeadScent;

        return $this;
    }

    public function getHeartScent(): ?HeartScent
    {
        return $this->heartScent;
    }

    public function setHeartScent(HeartScent $heartScent): self
    {
        $this->heartScent = $heartScent;

        return $this;
    }

    public function getProportionHeartScent(): ?string
    {
        return $this->proportionHeartScent;
    }

    public function setProportionHeartScent(string $proportionHeartScent): self
    {
        $this->proportionHeartScent = $proportionHeartScent;

        return $this;
    }

    public function getBaseScent(): ?BaseScent
    {
        return $this->baseScent;
    }

    public function setBaseScent(BaseScent $baseScent): self
    {
        $this->baseScent = $baseScent;

        return $this;
    }

    public function getProportionBaseScent(): ?string
    {
        return $this->proportionBaseScent;
    }

    public function setProportionBaseScent(string $roportionBaseScent): self
    {
        $this->proportionBaseScent = $roportionBaseScent;

        return $this;
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

    public function getSamplingValidation(): ?string
    {
        return $this->samplingValidation;
    }

    public function setSamplingValidation(string $samplingValidation): self
    {
        $this->samplingValidation = $samplingValidation;

        return $this;
    }

    public function isSamplingValidation(): ?bool
    {
        return $this->samplingValidation;
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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addCreatedPerfume($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeCreatedPerfume($this);
        }

        return $this;
    }
}
