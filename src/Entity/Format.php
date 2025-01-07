<?php

namespace App\Entity;

use App\Repository\FormatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: FormatRepository::class)]
class Format
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 13)]
    private ?string $ISBN = null;

    #[Groups(['searchable'])]
    #[ORM\Column]
    private ?float $priceHT = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column]
    private ?int $wordsCount = null;

    #[ORM\Column(length: 255)]
    private ?int $pagesCount = null;

    #[ORM\Column]
    private ?float $fileSize = null;

    #[ORM\Column(length: 255)]
    private ?string $filePath = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'formats')]
    private Collection $books;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bookExtract = null;

    #[Groups(['searchable'])]
    #[ORM\ManyToOne(inversedBy: 'formatType')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    public function __construct()
    {
        $this->books = new ArrayCollection();
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

}
