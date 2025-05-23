<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\FeedbackRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
// #[UniqueEntity(fields: ['nickName', 'format'], message: 'Vous avez déjà déjà donné votre avis sur ce livre.')]

class Feedback
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'feedbacks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $nickName = null;

    #[Assert\PositiveOrZero]
    #[Groups(['searchable', 'getBooks'])]
    #[ORM\Column]
    private ?int $stars = null;

    #[Assert\WordCount(min: 1, max: 200)]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(inversedBy: 'feedbacks')]
    private ?Format $format = null;

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
