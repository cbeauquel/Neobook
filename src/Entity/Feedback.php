<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
class Feedback
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'feedbacks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $nickName = null;

    #[ORM\Column]
    private ?int $stars = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $feedbackDate = null;

    #[ORM\ManyToOne(inversedBy: 'feedbacks')]
    private ?Book $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickName(): ?User
    {
        return $this->nickName;
    }

    public function setNickName(?User $nickName): static
    {
        $this->nickName = $nickName;

        return $this;
    }

    public function getStars(): ?int
    {
        return $this->stars;
    }

    public function setStars(int $stars): static
    {
        $this->stars = $stars;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getFeedbackDate(): ?\DateTimeInterface
    {
        return $this->feedbackDate;
    }

    public function setFeedbackDate(\DateTimeInterface $feedbackDate): static
    {
        $this->feedbackDate = $feedbackDate;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }
}
