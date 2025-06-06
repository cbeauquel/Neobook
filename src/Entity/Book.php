<?php

namespace App\Entity;

use App\Entity\KeyWord;
use App\Entity\Traits\TimestampableTrait;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    use TimestampableTrait;

    #[Groups(['searchable', 'getBooks'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['searchable', 'getBooks', 'getContributors', 'getEditors'])]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['searchable', 'getBooks'])]
    #[ORM\Column(length: 255)]
    private ?string $cover = null;

    #[Groups(['searchable', 'getBook'])]
    #[Assert\NotBlank]
    #[Assert\WordCount(min: 10, max: 400)]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $summary = null;

    #[Groups(['searchable', 'getBooks'])]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[Groups(['searchable', 'getBooks'])]
    #[Assert\NotBlank]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $parutionDate = null;

    // #[Assert\NotBlank]
    #[ORM\Column]
    private ?bool $status = null;

    /**
     * @var Collection<int, KeyWord>
     */
    #[Groups(['searchable', 'getBooks'])]
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: KeyWord::class, mappedBy: 'books', cascade: ['persist'])]
    private Collection $keyWords;

    /**
     * @var Collection<int, Category>
     */
    #[Groups(['searchable', 'getBooks'])]
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'books')]
    private Collection $categories;

    #[Groups(['searchable', 'getBooks'])]
    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'books', cascade: ['persist'], fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editor $editor = null;

    /**
     * @var Collection<int, BoSkCo>
     */
    #[Assert\Valid]
    #[Groups(['searchable', 'getBooks'])]
    #[ORM\OneToMany(targetEntity: BoSkCo::class, mappedBy: 'book', orphanRemoval: true, cascade: ['persist'], fetch: 'EAGER')]
    private Collection $boSkCos;

    /**
     * @var Collection<int, ToBeRead>
     */
    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: ToBeRead::class, mappedBy: 'book')]
    private Collection $toBeReads;

    /**
     * @var Collection<int, Format>
     */
    #[Assert\Valid]
    #[Groups(['searchable', 'getBooks'])]
    #[ORM\OneToMany(targetEntity: Format::class, mappedBy: 'book', orphanRemoval: true, cascade: ['persist'], fetch: 'EAGER')]
    private Collection $formats;

    public function __construct()
    {
        $this->keyWords = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->boSkCos = new ArrayCollection();
        $this->toBeReads = new ArrayCollection();
        $this->formats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getParutionDate(): ?\DateTimeInterface
    {
        return $this->parutionDate;
    }

    public function setParutionDate(\DateTimeInterface $parutionDate): static
    {
        $this->parutionDate = $parutionDate;

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
     * @return Collection<int, KeyWord>
     */
    public function getKeyWords(): Collection
    {
        return $this->keyWords;
    }

    public function addKeyWord(KeyWord $keyWord): static
    {
        if (!$this->keyWords->contains($keyWord)) {
            $this->keyWords->add($keyWord);
            $keyWord->addBook($this);
        }

        return $this;
    }

    public function removeKeyWord(KeyWord $keyWord): static
    {
        if ($this->keyWords->removeElement($keyWord)) {
            $keyWord->removeBook($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addBook($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            $category->removeBook($this);
        }

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): static
    {
        $this->editor = $editor;

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
            $boSkCo->setBook($this);
        }

        return $this;
    }

    public function removeBoSkCo(BoSkCo $boSkCo): static
    {
        if ($this->boSkCos->removeElement($boSkCo)) {
            // set the owning side to null (unless already changed)
            if ($boSkCo->getBook() === $this) {
                $boSkCo->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ToBeRead>
     */
    public function getToBeReads(): Collection
    {
        return $this->toBeReads;
    }

    public function addToBeReads(ToBeRead $toBeRead): static
    {
        if (!$this->toBeReads->contains($toBeRead)) {
            $this->toBeReads->add($toBeRead);
            $toBeRead->setBook($this);
        }

        return $this;
    }

    public function removetoBeRead(ToBeRead $toBeRead): static
    {
        if ($this->toBeReads->removeElement($toBeRead)) {
            // set the owning side to null (unless already changed)
            if ($toBeRead->getBook() === $this) {
                $toBeRead->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Format>
     */
    public function getFormats(): Collection
    {
        return $this->formats;
    }

    public function addFormat(Format $format): static
    {
        if (!$this->formats->contains($format)) {
            $this->formats->add($format);
            $format->setBook($this);
        }

        return $this;
    }

    public function removeFormat(Format $format): static
    {
        if ($this->formats->removeElement($format)) {
            // set the owning side to null (unless already changed)
            if ($format->getBook() === $this) {
                $format->setBook(null);
            }
        }

        return $this;
    }

    /**
     * Calcule la moyenne des notes sur tous les formats du livre
     */
    public function getAverageStars(): float
    {
        $feedbacks = array_merge(...array_map(
            fn ($format) => $format->getFeedbacks()->toArray(),
            $this->formats->toArray()
        ));

        $stars = array_map(fn ($fb) => $fb->getStars(), $feedbacks);

        return count($stars) > 0 ? array_sum($stars) / count($stars) : 0.0;
    }
}
