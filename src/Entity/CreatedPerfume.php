<?php

namespace App\Entity;

use App\Repository\CreatedPerfumeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CreatedPerfumeRepository::class)]
class CreatedPerfume
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\PositiveOrZero]
    #[Assert\LessThanOrEqual(100)]
    #[ORM\Column(length: 255)]
    private ?string $proportionHeadScent = '33';

    #[Assert\PositiveOrZero]
    #[Assert\LessThanOrEqual(100)]
    #[ORM\Column(length: 255)]
    private ?string $proportionHeartScent = '33';

    #[Assert\PositiveOrZero]
    #[Assert\LessThanOrEqual(100)]
    #[ORM\Column(length: 255)]
    private ?string $proportionBaseScent = '33';

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

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'createdPerfumes')]
    private Collection $products;

    #[ORM\ManyToOne(inversedBy: 'createdPerfumes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'createdPerfume', targetEntity: PurchasedProduct::class, orphanRemoval: true)]
    private Collection $purchasedProducts;

    #[ORM\OneToMany(mappedBy: 'createdPerfume', targetEntity: ProductQuantities::class, orphanRemoval: true)]
    private Collection $productQuantities;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->purchasedProducts = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->products->removeElement($product);

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

    /**
     * @return Collection<int, PurchasedProduct>
     */
    public function getPurchasedProducts(): Collection
    {
        return $this->purchasedProducts;
    }

    public function addPurchasedProduct(PurchasedProduct $purchasedProduct): self
    {
        if (!$this->purchasedProducts->contains($purchasedProduct)) {
            $this->purchasedProducts->add($purchasedProduct);
            $purchasedProduct->setCreatedPerfume($this);
        }

        return $this;
    }

    public function removePurchasedProduct(PurchasedProduct $purchasedProduct): self
    {
        if ($this->purchasedProducts->removeElement($purchasedProduct)) {
            // set the owning side to null (unless already changed)
            if ($purchasedProduct->getCreatedPerfume() === $this) {
                $purchasedProduct->setCreatedPerfume(null);
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
            $productQuantity->setCreatedPerfume($this);
        }

        return $this;
    }

    public function removeProductQuantity(ProductQuantities $productQuantity): self
    {
        if ($this->productQuantities->removeElement($productQuantity)) {
            // set the owning side to null (unless already changed)
            if ($productQuantity->getCreatedPerfume() === $this) {
                $productQuantity->setCreatedPerfume(null);
            }
        }

        return $this;
    }
}
