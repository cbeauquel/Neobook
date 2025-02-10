<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Format>
     */
    #[Assert\NotBlank]
    #[ORM\OneToMany(targetEntity: Format::class, mappedBy: 'type')]
    private Collection $formatType;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $typeImg = null;

    #[Groups(['searchable', 'getBooks'])]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->formatType = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Format>
     */
    public function getFormatType(): Collection
    {
        return $this->formatType;
    }

    public function addFormatType(Format $formatType): static
    {
        if (!$this->formatType->contains($formatType)) {
            $this->formatType->add($formatType);
            $formatType->setType($this);
        }

        return $this;
    }

    public function removeFormatType(Format $formatType): static
    {
        if ($this->formatType->removeElement($formatType)) {
            // set the owning side to null (unless already changed)
            if ($formatType->getType() === $this) {
                $formatType->setType(null);
            }
        }

        return $this;
    }

    public function getTypeImg(): ?string
    {
        return $this->typeImg;
    }

    public function setTypeImg(string $typeImg): static
    {
        $this->typeImg = $typeImg;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
