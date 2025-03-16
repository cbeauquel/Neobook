<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['searchable', 'getBooks', 'getContributors'])]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, BoSkCo>
     */
    #[Assert\NotBlank]
    #[ORM\OneToMany(targetEntity: BoSkCo::class, mappedBy: 'skill')]
    private Collection $boSkCos;

    public function __construct()
    {
        $this->boSkCos = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, BoSkCo>
     */
    public function getBoSkCos(): Collection
    {
        return $this->boSkCos;
    }

    public function setBoSkCos(Collection $boSkCos): static
    {
        $this->boSkCos = $boSkCos;
        return $this;
    }

    public function addBoSkCo(BoSkCo $boSkCo): static
    {
        if (!$this->boSkCos->contains($boSkCo)) {
            $this->boSkCos->add($boSkCo);
            $boSkCo->setSkill($this);
        }

        return $this;
    }

    public function removeBoSkCo(BoSkCo $boSkCo): static
    {
        if ($this->boSkCos->removeElement($boSkCo)) {
            // set the owning side to null (unless already changed)
            if ($boSkCo->getSkill() === $this) {
                $boSkCo->setSkill(null);
            }
        }

        return $this;
    }

}
