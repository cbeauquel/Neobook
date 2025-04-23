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
    #[Assert\Length(min: 13, max: 13)]
    #[ORM\Column(length: 13)]
    private ?string $ISBN = null;

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

    #[Assert\NotBlank]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bookExtract = null;

    #[Groups(['searchable', 'getBooks'])]
    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'formatType', cascade: ['persist'], fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[Assert\NotBlank]
    #[Groups(['searchable', 'getBooks'])]
    #[ORM\Column(type: 'decimal', precision: 4, scale: 2)]
    private ?string $priceHT = null;

    #[Groups(['getBooks'])]
    #[Assert\NotBlank]
    #[ORM\Column(type: 'decimal', precision: 4, scale: 2)]
    private ?string $priceTTC = null;

    #[Assert\Valid]
    #[ORM\ManyToOne(inversedBy: 'formatTvaRate', cascade: ['persist'], fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tva $tvaRate = null;

    /**
     * @var Collection<int, Basket>
     */
    #[ORM\ManyToMany(targetEntity: Basket::class, mappedBy: 'formats', cascade: ['persist'])]
    private Collection $baskets;

    #[Assert\NotBlank]
    #[ORM\ManyToOne(inversedBy: 'formats', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    /**
     * @var Collection<int, Feedback>
     */
    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: Feedback::class, mappedBy: 'format', fetch: 'EAGER')]
    private Collection $feedbacks;

    public function __construct()
    {
        $this->baskets = new ArrayCollection();
        $this->feedbacks = new ArrayCollection();
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
    
    public function getPriceHT(): ?string
    {
        return $this->priceHT;
    }

    public function setPriceHT(string $priceHT): static
    {
        $this->priceHT = $priceHT;

        return $this;
    }


    public function getPriceTTC(): ?string
    {
        return $this->priceTTC;
    }

    public function setPriceTTC(string $priceTTC): static
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

    public function setBaskets(Collection $baskets): static
    {
        $this->baskets = $baskets;
        return $this;
    }

    public function removeBasket(Basket $basket): static
    {
        if ($this->baskets->removeElement($basket)) {
            $basket->removeFormat($this);
        }

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

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
            $feedback->setFormat($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): static
    {
        if ($this->feedbacks->removeElement($feedback)) {
            // set the owning side to null (unless already changed)
            if ($feedback->getFormat() === $this) {
                $feedback->setFormat(null);
            }
        }

        return $this;
    }
}
