<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\DownloadLinkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: DownloadLinkRepository::class)]
class DownloadLink
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 64, unique: true)]
    private ?string $token = null;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(inversedBy: 'downloadLinks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $customer = null;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(inversedBy: 'downloadLinks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Format $format = null;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(inversedBy: 'downloadLinks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order = null;

    #[Assert\PositiveOrZero]
    #[ORM\Column]
    private int $downloadCount = 0;

    #[Assert\Positive]
    #[ORM\Column]
    private int $maxDownloads = 5;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $expiresAt = null;

    #[ORM\Column]
    private bool $isActive = true;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lastDownloadAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;
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

    public function getFormat(): ?Format
    {
        return $this->format;
    }

    public function setFormat(?Format $format): static
    {
        $this->format = $format;
        return $this;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;
        return $this;
    }

    public function getDownloadCount(): int
    {
        return $this->downloadCount;
    }

    public function setDownloadCount(int $downloadCount): static
    {
        $this->downloadCount = $downloadCount;
        return $this;
    }

    public function incrementDownloadCount(): static
    {
        $this->downloadCount++;
        $this->lastDownloadAt = new \DateTime();
        return $this;
    }

    public function getMaxDownloads(): int
    {
        return $this->maxDownloads;
    }

    public function setMaxDownloads(int $maxDownloads): static
    {
        $this->maxDownloads = $maxDownloads;
        return $this;
    }

    public function getExpiresAt(): ?\DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTimeInterface $expiresAt): static
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getLastDownloadAt(): ?\DateTimeInterface
    {
        return $this->lastDownloadAt;
    }

    public function setLastDownloadAt(?\DateTimeInterface $lastDownloadAt): static
    {
        $this->lastDownloadAt = $lastDownloadAt;
        return $this;
    }

    /**
     * Vérifie si le lien est encore valide pour téléchargement
     */
    public function isValidForDownload(): bool
    {
        // Vérifier si le lien est actif
        if (!$this->isActive) {
            return false;
        }

        // Vérifier si le nombre max de téléchargements n'est pas atteint
        if ($this->downloadCount >= $this->maxDownloads) {
            return false;
        }

        // Vérifier si le lien n'a pas expiré
        if ($this->expiresAt && $this->expiresAt < new \DateTime()) {
            return false;
        }

        return true;
    }

    /**
     * Génère un token unique sécurisé
     */
    public function generateToken(): static
    {
        $this->token = bin2hex(random_bytes(32));
        return $this;
    }
}
