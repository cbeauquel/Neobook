<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SaleRepository::class)]
class Sale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?\DateTime $salesStartDate = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?\DateTime $salesEndDate = null;

    #[ORM\Column(type: 'decimal', precision: 4, scale: 2)]
    #[Assert\NotBlank]
    private ?string $reducedPriceHt = null;

    #[ORM\Column(type: 'decimal', precision: 4, scale: 2)]
    #[Assert\NotBlank]
    private ?string $reducedPriceTtc = null;

    #[ORM\ManyToOne(inversedBy: 'sales')]
    #[Assert\NotBlank]
    private ?Format $format = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalesStartDate(): ?\DateTime
    {
        return $this->salesStartDate;
    }

    public function setSalesStartDate(\DateTime $salesStartDate): static
    {
        $this->salesStartDate = $salesStartDate;

        return $this;
    }

    public function getSalesEndDate(): ?\DateTime
    {
        return $this->salesEndDate;
    }

    public function setSalesEndDate(\DateTime $salesEndDate): static
    {
        $this->salesEndDate = $salesEndDate;

        return $this;
    }

    public function getReducedPriceHt(): ?string
    {
        return $this->reducedPriceHt;
    }

    public function setReducedPriceHt(string $reducedPriceHt): static
    {
        $this->reducedPriceHt = $reducedPriceHt;

        return $this;
    }

    public function getReducedPriceTtc(): ?string
    {
        return $this->reducedPriceTtc;
    }

    public function setReducedPriceTtc(string $reducedPriceTtc): static
    {
        $this->reducedPriceTtc = $reducedPriceTtc;

        return $this;
    }

    public function getFormat(): ?Format
    {
        return $this->format;
    }

    public function setFormat(?Format $format): static
    {
        $this->format = $format;

        return $this;
    }
}
