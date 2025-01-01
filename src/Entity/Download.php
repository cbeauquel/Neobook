<?php

namespace App\Entity;

use App\Repository\DownloadRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DownloadRepository::class)]
class Download
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $expirationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $downloadUrl = null;

    #[ORM\Column]
    private ?int $downloadCount = null;

    #[ORM\Column]
    private ?int $maxAttempts = null;

    #[ORM\ManyToOne(inversedBy: 'downloads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $oderDownload = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeInterface $expirationDate): static
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getDownloadUrl(): ?string
    {
        return $this->downloadUrl;
    }

    public function setDownloadUrl(string $downloadUrl): static
    {
        $this->downloadUrl = $downloadUrl;

        return $this;
    }

    public function getDownloadCount(): ?int
    {
        return $this->downloadCount;
    }

    public function setDownloadCount(int $downloadCount): static
    {
        $this->downloadCount = $downloadCount;

        return $this;
    }

    public function getMaxAttempts(): ?int
    {
        return $this->maxAttempts;
    }

    public function setMaxAttempts(int $maxAttempts): static
    {
        $this->maxAttempts = $maxAttempts;

        return $this;
    }

    public function getOderDownload(): ?Order
    {
        return $this->oderDownload;
    }

    public function setOderDownload(?Order $oderDownload): static
    {
        $this->oderDownload = $oderDownload;

        return $this;
    }
}
