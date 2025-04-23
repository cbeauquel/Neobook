<?php

namespace App\Entity;

use App\Repository\BoSkCoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoSkCoRepository::class)]
class BoSkCo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Groups(['getContributors', 'getEditors'])]
    #[ORM\ManyToOne(inversedBy: 'boSkCos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    #[Assert\Valid]
    #[Groups(['searchable', 'getBooks'])]
    #[ORM\ManyToOne(inversedBy: 'boSkCos', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contributor $contributor = null;

    #[Assert\Valid]
    #[Groups(['searchable', 'getBooks', 'getContributors'])]
    #[ORM\ManyToOne(inversedBy: 'boSkCos', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Skill $skill = null;

    // @codeCoverageIgnoreStart
    public function getId(): ?int
    {
        return $this->id;
    }
    // @codeCoverageIgnoreEnd

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }

    public function getContributor(): ?Contributor
    {
        return $this->contributor;
    }

    public function setContributor(?Contributor $contributor): static
    {
        $this->contributor = $contributor;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }
}
