<?php

namespace App\Entity;

use App\Repository\ContributorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: ContributorRepository::class)]
class Contributor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['searchable'])]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[Groups(['searchable'])]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $bio = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAdd = null;

    /**
     * @var Collection<int, BoSkCo>
     */
    #[ORM\OneToMany(targetEntity: BoSkCo::class, mappedBy: 'contributor', orphanRemoval: true)]
    private Collection $boSkCos;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): static
    {
        $this->dateAdd = $dateAdd;

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
}
