<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?bool $newCustomer = null;

    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $customer = null;

    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrderStatus $status = null;

    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Payment $paymentMode = null;

    #[ORM\OneToOne(inversedBy: 'orderId', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Basket $basket = null;

    #[ORM\OneToOne(inversedBy: 'user_token_id', cascade: ['persist', 'remove'])]
    private ?Basket $user_token = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'decimal', precision: 4, scale: 2)]
    private ?string $TotalHT = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'decimal', precision: 4, scale: 2)]
    private ?string $TotalTTC = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isNewCustomer(): ?bool
    {
        return $this->newCustomer;
    }

    public function setNewCustomer(bool $newCustomer): static
    {
        $this->newCustomer = $newCustomer;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getStatus(): ?OrderStatus
    {
        return $this->status;
    }

    public function setStatus(?OrderStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPaymentMode(): ?Payment
    {
        return $this->paymentMode;
    }

    public function setPaymentMode(?Payment $paymentMode): static
    {
        $this->paymentMode = $paymentMode;

        return $this;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(Basket $basket): static
    {
        $this->basket = $basket;

        return $this;
    }

    public function getUserToken(): ?Basket
    {
        return $this->user_token;
    }

    public function setUserToken(?Basket $user_token): static
    {
        $this->user_token = $user_token;

        return $this;
    }

    public function getTotalHT(): ?string
    {
        return $this->TotalHT;
    }

    public function setTotalHT(string $TotalHT): static
    {
        $this->TotalHT = $TotalHT;

        return $this;
    }

    public function getTotalTTC(): ?string
    {
        return $this->TotalTTC;
    }

    public function setTotalTTC(string $TotalTTC): static
    {
        $this->TotalTTC = $TotalTTC;

        return $this;
    }
}
