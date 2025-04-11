<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ORM\HasLifecycleCallbacks]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Email]
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[Assert\PasswordStrength]
    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $lastVisitDate = null;

    #[ORM\Column]
    private ?bool $optIn = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $preference = null;

    /**
     * @var Collection<int, Basket>
     */
    #[Assert\NotBlank]
    #[ORM\OneToMany(targetEntity: Basket::class, mappedBy: 'customer')]
    private Collection $baskets;

    /**
     * @var Collection<int, Order>
     */
    #[Assert\NotBlank]
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'customer')]
    private Collection $orders;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $nickname = null;

    /**
     * @var Collection<int, Feedback>
     */
    #[Assert\NotBlank]
    #[ORM\OneToMany(targetEntity: Feedback::class, mappedBy: 'nickName', orphanRemoval: true)]
    private Collection $feedbacks;

    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * @var Collection<int, ToBeRead>
     */
    #[ORM\OneToMany(targetEntity: ToBeRead::class, mappedBy: 'customer')]
    private Collection $toBeReads;

    public function __construct()
    {
        $this->baskets = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->feedbacks = new ArrayCollection();
        $this->toBeReads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLastVisitDate(): ?\DateTimeInterface
    {
        return $this->lastVisitDate;
    }

    public function setLastVisitDate(\DateTimeInterface $lastVisitDate): static
    {
        $this->lastVisitDate = $lastVisitDate;

        return $this;
    }

    public function isOptIn(): ?bool
    {
        return $this->optIn;
    }

    public function setOptIn(bool $OptIn): static
    {
        $this->optIn = $OptIn;

        return $this;
    }

    public function getPreference(): ?string
    {
        return $this->preference;
    }

    public function setPreference(string $preference): static
    {
        $this->preference = $preference;

        return $this;
    }

    /**
     * @return Collection<int, Basket>
     */
    public function getBaskets(): Collection
    {
        return $this->baskets;
    }

    public function addBasket(Basket $basket): static
    {
        if (!$this->baskets->contains($basket)) {
            $this->baskets->add($basket);
            $basket->setCustomer($this);
        }

        return $this;
    }
    
    public function setBaskets(Collection $baskets): static
    {
        $this->baskets = $baskets;
        return $this;
    }

    public function removeBasket(Basket $basket): static
    {
        if ($this->baskets->removeElement($basket)) {
            // set the owning side to null (unless already changed)
            if ($basket->getCustomer() === $this) {
                $basket->setCustomer(null);
            }
        }

        return $this;
    }

    public function getNickName(): ?string
    {
        return $this->nickname;
    }

    public function setNickName(string $nickName): static
    {
        $this->nickname = $nickName;

        return $this;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getFeedbacks(): Collection
    {
        return $this->feedbacks;
    }

    public function addFeedback(Feedback $feedback): static
    {
        if (!$this->feedbacks->contains($feedback)) {
            $this->feedbacks->add($feedback);
            $feedback->setNickName($this);
        }

        return $this;
    }

    public function setFeedbacks(Collection $feedbacks): static
    {
        $this->feedbacks = $feedbacks;
        return $this;
    }
    
    public function removeFeedback(Feedback $feedback): static
    {
        if ($this->feedbacks->removeElement($feedback)) {
            // set the owning side to null (unless already changed)
            if ($feedback->getNickName() === $this) {
                $feedback->setNickName(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setCustomer($this);
        }

        return $this;
    }
 
    public function setOrders(Collection $orders): static
    {
        $this->orders = $orders;
        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ToBeRead>
     */
    public function getToBeReads(): Collection
    {
        return $this->toBeReads;
    }

    public function addToBeRead(ToBeRead $toBeRead): static
    {
        if (!$this->toBeReads->contains($toBeRead)) {
            $this->toBeReads->add($toBeRead);
            $toBeRead->setCustomer($this);
        }

        return $this;
    }

    public function setToBeReads(Collection $toBeReads): static
    {
        $this->toBeReads = $toBeReads;
        return $this;
    }

    public function removeToBeRead(ToBeRead $toBeRead): static
    {
        if ($this->toBeReads->removeElement($toBeRead)) {
            // set the owning side to null (unless already changed)
            if ($toBeRead->getCustomer() === $this) {
                $toBeRead->setCustomer(null);
            }
        }

        return $this;
    }
}
