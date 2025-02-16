<?php

namespace App\Entity;

use App\Repository\FormatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: FormatRepository::class)]
class Format
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[Groups(['searchable', 'getBooks'])]
    // #[Assert\Isbn(
    //     type:Assert\Isbn::ISBN_13
    // )]
    #[Assert\Length(min:13, max:13)]
    #[ORM\Column(length: 13)]
    private ?string $ISBN = null;

    #[Assert\NotBlank]
    #[Groups(['searchable', 'getBooks'])]
    #[ORM\Column]
    private ?float $priceHT = null;

    #[Groups(['searchable', 'getBooks'])]
    #[Assert\PositiveOrZero]
    #[ORM\Column]
    private ?int $duration = null;

    #[Groups(['searchable', 'getBooks'])]
    #[Assert\PositiveOrZero]
    #[ORM\Column]
    private ?int $wordsCount = null;

    #[Groups(['searchable', 'getBooks'])]
    #[Assert\PositiveOrZero]
    #[ORM\Column(length: 255)]
    private ?int $pagesCount = null;

    #[Groups(['getBooks'])]
    #[Assert\PositiveOrZero]
    #[ORM\Column]
    private ?float $fileSize = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $filePath = null;

    /**
     * @var Collection<int, Book>
     */
    #[Assert\NotBlank]
    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'formats')]
    private Collection $books;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bookExtract = null;

    #[Groups(['searchable', 'getBooks'])]
    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'formatType', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[Groups(['getBooks'])]
    #[Assert\NotBlank]
    #[ORM\Column]
    private ?float $priceTTC = null;

    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'formatTvaRate', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tva $tvaRate = null;

    /**
     * @var Collection<int, Basket>
     */
    #[ORM\ManyToMany(targetEntity: Basket::class, mappedBy: 'formats', cascade: ['persist'])]
    private Collection $baskets;

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->baskets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getPriceHT(): ?float
    {
        return $this->priceHT;
    }

    public function setPriceHT(float $priceHT): static
    {
        $this->priceHT = $priceHT;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getWordsCount(): ?int
    {
        return $this->wordsCount;
    }

    public function setWordsCount(int $wordsCount): static
    {
        $this->wordsCount = $wordsCount;

        return $this;
    }

    public function getPagesCount(): ?int
    {
        return $this->pagesCount;
    }

    public function setPagesCount(int $pagesCount): static
    {
        $this->pagesCount = $pagesCount;

        return $this;
    }

    public function getFileSize(): ?float
    {
        return $this->fileSize;
    }

    public function setFileSize(float $fileSize): static
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addFormat($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            $book->removeFormat($this);
        }

        return $this;
    }

    public function getBookExtract(): ?string
    {
        return $this->bookExtract;
    }

    public function setBookExtract(?string $bookExtract): static
    {
        $this->bookExtract = $bookExtract;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPriceTTC(): ?float
    {
        return $this->priceTTC;
    }

    public function setPriceTTC(float $priceTTC): static
    {
        $this->priceTTC = $priceTTC;

        return $this;
    }

    public function getTvaRate(): ?Tva
    {
        return $this->tvaRate;
    }

    public function setTvaRate(?Tva $TvaRate): static
    {
        $this->tvaRate = $TvaRate;

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
            $basket->addFormat($this);
        }

        return $this;
    }

    public function removeBasket(Basket $basket): static
    {
        if ($this->baskets->removeElement($basket)) {
            $basket->removeFormat($this);
        }

        return $this;
    }

}
