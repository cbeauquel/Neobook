<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\ContributorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ContributorRepository::class)]
class Contributor
{
    use TimestampableTrait;

    #[Groups(['getContributors'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Groups(['searchable', 'getBooks', 'getContributors'])]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[Assert\NotBlank]
    #[Groups(['searchable', 'getBooks', 'getContributors'])]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Assert\NotBlank]
    #[Groups(['getContributor'])]
    #[Assert\WordCount(min: 10, max: 400)]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $bio = null;

    #[Assert\NotBlank]
    #[Groups(['getContributors'])]
    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[Assert\NotBlank]
    #[ORM\Column]
    private ?bool $status = null;

    /**
     * @var Collection<int, BoSkCo>
     */
    #[Assert\NotBlank]
    #[Groups(['getContributors'])]
    #[ORM\OneToMany(targetEntity: BoSkCo::class, mappedBy: 'contributor', orphanRemoval: true, cascade: ['persist'])]
    private Collection $boSkCos;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->boSkCos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, BoSkCo>
     */
    public function getBoSkCos(): Collection
    {
        return $this->boSkCos;
    }

    public function addBoSkCo(BoSkCo $boSkCo): static
    {
        if (!$this->boSkCos->contains($boSkCo)) {
            $this->boSkCos->add($boSkCo);
            $boSkCo->setContributor($this);
        }

        return $this;
    }

    public function setBoSkCos(Collection $boSkCos): static
    {
        $this->boSkCos = $boSkCos;
        return $this;
    }


    public function removeBoSkCo(BoSkCo $boSkCo): static
    {
        if ($this->boSkCos->removeElement($boSkCo)) {
            // set the owning side to null (unless already changed)
            if ($boSkCo->getContributor() === $this) {
                $boSkCo->setContributor(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
