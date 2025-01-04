<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $cover = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $summary = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $parutionDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $bookUpdate = null;

    #[ORM\Column]
    private ?bool $status = null;

    /**
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, mappedBy: 'books')]
    private Collection $authors;

    /**
     * @var Collection<int, KeyWords>
     */
    #[ORM\ManyToMany(targetEntity: KeyWords::class, mappedBy: 'books')]
    private Collection $keyWords;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'books')]
    private Collection $categories;

    /**
     * @var Collection<int, Format>
     */
    #[ORM\ManyToMany(targetEntity: Format::class, inversedBy: 'books')]
    private Collection $formats;

    /**
     * @var Collection<int, Basket>
     */
    #[ORM\ManyToMany(targetEntity: Basket::class, mappedBy: 'books')]
    private Collection $baskets;

    /**
     * @var Collection<int, Order>
     */
    #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'books')]
    private Collection $orders;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    /**
     * @var Collection<int, Feedback>
     */
    #[ORM\OneToMany(targetEntity: Feedback::class, mappedBy: 'book')]
    private Collection $feedbacks;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editor $editor = null;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
        $this->keyWords = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->formats = new ArrayCollection();
        $this->baskets = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->feedbacks = new ArrayCollection();
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

    public function getBookUpdate(): ?\DateTimeInterface
    {
        return $this->bookUpdate;
    }

    public function setBookUpdate(\DateTimeInterface $bookUpdate): static
    {
        $this->bookUpdate = $bookUpdate;

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
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addBook($this);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        if ($this->authors->removeElement($author)) {
            $author->removeBook($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, KeyWords>
     */
    public function getKeyWords(): Collection
    {
        return $this->keyWords;
    }

    public function addKeyWord(KeyWords $keyWord): static
    {
        if (!$this->keyWords->contains($keyWord)) {
            $this->keyWords->add($keyWord);
            $keyWord->addBook($this);
        }

        return $this;
    }

    public function removeKeyWord(KeyWords $keyWord): static
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
        }

        return $this;
    }

    public function removeFormat(Format $format): static
    {
        $this->formats->removeElement($format);

        return $this;
    }

    /**
     * @return Collection<int, Basket>
     */
    public function getBaskets(): Collection
    {
        return $this->baskets;
    }

    public function addBasket(Basket $basket): static
    {
        if (!$this->baskets->contains($basket)) {
            $this->baskets->add($basket);
            $basket->addBook($this);
        }

        return $this;
    }

    public function removeBasket(Basket $basket): static
    {
        if ($this->baskets->removeElement($basket)) {
            $basket->removeBook($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->addBook($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            $order->removeBook($this);
        }

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getFeedbacks(): Collection
    {
        return $this->feedbacks;
    }

    public function addFeedback(Feedback $feedback): static
    {
        if (!$this->feedbacks->contains($feedback)) {
            $this->feedbacks->add($feedback);
            $feedback->setBook($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): static
    {
        if ($this->feedbacks->removeElement($feedback)) {
            // set the owning side to null (unless already changed)
            if ($feedback->getBook() === $this) {
                $feedback->setBook(null);
            }
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
}
