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

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\ManyToMany(targetEntity: CreatedPerfume::class, mappedBy: 'product')]
    private Collection $createdPerfumes;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: PurchasedProduct::class, orphanRemoval: true)]
    private Collection $purchasedProduct;

    #[ORM\ManyToMany(targetEntity: ProductQuantities::class, inversedBy: 'products')]
    private Collection $productQuantities;

    public function __construct()
    {
        $this->createdPerfumes = new ArrayCollection();
        $this->purchasedProduct = new ArrayCollection();
        $this->productQuantities = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
     * @return Collection<int, CreatedPerfume>
     */
    public function getCreatedPerfumes(): Collection
    {
        return $this->createdPerfumes;
    }

    public function addCreatedPerfume(CreatedPerfume $createdPerfume): self
    {
        if (!$this->createdPerfumes->contains($createdPerfume)) {
            $this->createdPerfumes->add($createdPerfume);
            $createdPerfume->addProduct($this);
        }

        return $this;
    }

    public function removeCreatedPerfume(CreatedPerfume $createdPerfume): self
    {
        if ($this->createdPerfumes->removeElement($createdPerfume)) {
            $createdPerfume->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PurchasedProduct>
     */
    public function getPurchasedProduct(): Collection
    {
        return $this->purchasedProduct;
    }

    public function addPurchasedProduct(PurchasedProduct $purchasedProduct): self
    {
        if (!$this->purchasedProduct->contains($purchasedProduct)) {
            $this->purchasedProduct->add($purchasedProduct);
            $purchasedProduct->setProduct($this);
        }

        return $this;
    }

    public function removePurchasedProduct(PurchasedProduct $purchasedProduct): self
    {
        if ($this->purchasedProduct->removeElement($purchasedProduct)) {
            // set the owning side to null (unless already changed)
            if ($purchasedProduct->getProduct() === $this) {
                $purchasedProduct->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductQuantities>
     */
    public function getProductQuantities(): Collection
    {
        return $this->productQuantities;
    }

    public function addProductQuantity(ProductQuantities $productQuantity): self
    {
        if (!$this->productQuantities->contains($productQuantity)) {
            $this->productQuantities->add($productQuantity);
        }

        return $this;
    }

    public function removeProductQuantity(ProductQuantities $productQuantity): self
    {
        $this->productQuantities->removeElement($productQuantity);

        return $this;
    }
}