<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Contributor>
     */
    #[ORM\OneToMany(targetEntity: Contributor::class, mappedBy: 'skill')]
    private Collection $contributors;

    public function __construct()
    {
        $this->contributors = new ArrayCollection();
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
     * @return Collection<int, Contributor>
     */
    public function getContributors(): Collection
    {
        return $this->contributors;
    }

    public function addContributor(Contributor $contributor): static
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors->add($contributor);
            $contributor->setSkill($this);
        }

        return $this;
    }

    public function removeContributor(Contributor $contributor): static
    {
        if ($this->contributors->removeElement($contributor)) {
            // set the owning side to null (unless already changed)
            if ($contributor->getSkill() === $this) {
                $contributor->setSkill(null);
            }
        }

        return $this;
    }

}
