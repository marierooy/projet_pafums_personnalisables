<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $zipCode = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(type: 'boolean', nullable: false, options:['default' => 0])]
    private ?bool $active = null;

    #[Timestampable(on:"create")]
    #[ORM\Column(updatable: false)]
    private ?\DateTimeImmutable $createdAt = null;

    #[Timestampable]
    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CreatedPerfume::class, orphanRemoval: true)]
    private Collection $createdPerfumes;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ProductQuantities::class, orphanRemoval: true)]
    private Collection $productQuantities;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->createdPerfumes = new ArrayCollection();
        $this->productQuantities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string|null $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    
    public function getCompleteAddress() {
        return $this->address . ' ' . $this->city . ' ' . $this->zipCode . ' ' . $this->country;
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
            $createdPerfume->setUser($this);
        }

        return $this;
    }

    public function removeCreatedPerfume(CreatedPerfume $createdPerfume): self
    {
        if ($this->createdPerfumes->removeElement($createdPerfume)) {
            // set the owning side to null (unless already changed)
            if ($createdPerfume->getUser() === $this) {
                $createdPerfume->setUser(null);
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
            $productQuantity->setUser($this);
        }

        return $this;
    }

    public function removeProductQuantity(ProductQuantities $productQuantity): self
    {
        if ($this->productQuantities->removeElement($productQuantity)) {
            // set the owning side to null (unless already changed)
            if ($productQuantity->getUser() === $this) {
                $productQuantity->setUser(null);
            }
        }

        return $this;
    }
}
