<?php

namespace App\Entity;

use App\Repository\ProductQuantitiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductQuantitiesRepository::class)]
class ProductQuantities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productQuantities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CreatedPerfume $createdPerfume = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'productQuantities')]
    private Collection $products;

    #[ORM\Column(type: Types::ARRAY)]
    private array $quantities = [];

    #[ORM\ManyToOne(inversedBy: 'productQuantities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCreatedPerfume(): ?CreatedPerfume
    {
        return $this->createdPerfume;
    }

    public function setCreatedPerfume(?CreatedPerfume $createdPerfume): self
    {
        $this->createdPerfume = $createdPerfume;

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
            $product->addProductQuantity($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeProductQuantity($this);
        }

        return $this;
    }

    public function getQuantities(): array
    {
        return $this->quantities;
    }

    public function setQuantities(array $quantities): self
    {
        $this->quantities = $quantities;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
