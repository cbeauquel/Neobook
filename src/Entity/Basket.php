<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Enum\BasketStatus;
use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: BasketRepository::class)]
class Basket
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(inversedBy: 'baskets')]
    private ?User $customer = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userToken = null;

    /**
     * @var Collection<int, Format>
     */
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Format::class, inversedBy: 'baskets', cascade: ['persist'])]
    private Collection $formats;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'decimal', precision: 4, scale: 2)]
    private ?string $totalHT = null;

    #[Assert\NotBlank()]
    #[ORM\Column(type: 'decimal', precision: 4, scale: 2)]
    private ?string $totalTTC = null;

    #[ORM\Column(type: 'string', enumType: BasketStatus::class)]
    private BasketStatus $status;

    #[ORM\OneToOne(mappedBy: 'basket', cascade: ['persist', 'remove'])]
    private ?Order $orderId = null;

    public function __construct()
    {
        $this->formats = new ArrayCollection();
        $this->status = BasketStatus::IN_PROGRESS; // Initialisation par défaut
        $this->totalHT = '0';
        $this->totalTTC = '0';
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserToken(): ?string
    {
        return $this->userToken;
    }

    public function setUserToken(string $userToken): static
    {
        $this->userToken = $userToken;

        return $this;
    }

    /**
     * @return Collection<int, Format>
     */
    public function getFormats(): Collection
    {
        return $this->formats;
    }

    public function addFormat(Format $format): static
    {
        if (!$this->formats->contains($format)) {
            $this->formats->add($format);
        }

        return $this;
    }
    
    public function setFormats(Collection $formats): static
    {
        $this->formats = $formats;
        return $this;
    }

    public function removeFormat(Format $format): static
    {
        $this->formats->removeElement($format);

        return $this;
    }

    public function getTotalHT(): ?string
    {
        return $this->totalHT;
    }

    public function setTotalHT(string $totalHT): static
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    public function getTotalTTC(): ?string
    {
        return $this->totalTTC;
    }

    public function setTotalTTC(string $totalTTC): static
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }

    /**
     * @return BasketStatus
     */
    public function getStatus(): BasketStatus
    {
        return $this->status;
    }

    public function setStatus(BasketStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getOrderId(): ?Order
    {
        return $this->orderId;
    }

    public function setOrderId(Order $orderId): static
    {
        // set the owning side of the relation if necessary
        if ($orderId->getBasket() !== $this) {
            $orderId->setBasket($this);
        }

        $this->orderId = $orderId;

        return $this;
    }
}
