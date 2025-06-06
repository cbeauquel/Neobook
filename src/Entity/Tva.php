<?php

namespace App\Entity;

use App\Repository\TvaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TvaRepository::class)]
class Tva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Type(
        type: 'float',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    #[ORM\Column]
    private ?float $taux = null;
    
    /**
     * @var Collection<int, Format>
     */
    #[Assert\NotBlank]
    #[ORM\OneToMany(targetEntity: Format::class, mappedBy: 'tvaRate')]
    private Collection $formatTvaRate;

    public function __construct()
    {
        $this->formatTvaRate = new ArrayCollection();
    }

    // @codeCoverageIgnoreStart
    public function getId(): ?int
    {
        return $this->id;
    }
    // @codeCoverageIgnoreEnd

    public function getTaux(): ?float
    {
        return $this->taux;
    }

    public function setTaux(float $taux): static
    {
        $this->taux = $taux;

        return $this;
    }

    /**
     * @return Collection<int, Format>
     */
    public function getFormatTvaRate(): Collection
    {
        return $this->formatTvaRate;
    }

    public function addFormat(Format $format): static
    {
        if (!$this->formatTvaRate->contains($format)) {
            $this->formatTvaRate->add($format);
            $format->setTvaRate($this);
        }

        return $this;
    }
    
    public function setFormatTvaRate(Collection $formatTvaRate): static
    {
        $this->formatTvaRate = $formatTvaRate;
        return $this;
    }

    public function removeFormat(Format $format): static
    {
        if ($this->formatTvaRate->removeElement($format)) {
            // set the owning side to null (unless already changed)
            if ($format->getTvaRate() === $this) {
                $format->setTvaRate(null);
            }
        }

        return $this;
    }
}
