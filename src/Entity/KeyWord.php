<?php

namespace App\Entity;

use App\Repository\KeyWordRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: KeyWordRepository::class)]
class KeyWord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Groups(['searchable', 'getBooks'])]
    #[ORM\Column(length: 255)]
    private ?string $tag = null;

    /**
     * @var Collection<int, Book>
     */
    #[Assert\NotBlank]
    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'keyWords')]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    // @codeCoverageIgnoreStart
    public function getId(): ?int
    {
        return $this->id;
    }
    // @codeCoverageIgnoreEnd

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): static
    {
        $this->tag = $tag;

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
        }

        return $this;
    }

    public function setBooks(Collection $books): static
    {
        $this->books = $books;
        return $this;
    }

    public function removeBook(Book $book): static
    {
        $this->books->removeElement($book);

        return $this;
    }
}
