<?php

namespace App\Entity;

use App\Enum\BasketStatus;
use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TimestampableTrait;
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

    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'baskets')]
    private ?User $customer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $userToken = null;

    /**
     * @var Collection<int, Format>
     */
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Format::class, inversedBy: 'baskets', cascade: ['persist'])]
    private Collection $formats;

    #[Assert\NotBlank()]
    #[ORM\Column]
    private ?float $totalHT = null;

    #[Assert\NotBlank()]
    #[ORM\Column]
    private ?float $totalTTC = null;

    #[ORM\Column(type: 'string', enumType: BasketStatus::class)]
    private BasketStatus $status;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
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
    
    public function setFormats(Collection $formats): self
    {
        $this->formats = $formats;
        return $this;
    }

    public function removeFormat(Format $format): static
    {
        $this->formats->removeElement($format);

        return $this;
    }

    public function getTotalHT(): ?float
    {
        return $this->totalHT;
    }

    public function setTotalHT(float $totalHT): static
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    public function getTotalTTC(): ?float
    {
        return $this->totalTTC;
    }

    public function setTotalTTC(float $totalTTC): static
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }

    /**
     * @return BasketStatus[]
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
}
