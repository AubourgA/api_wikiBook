<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $ISBN = null;

    #[ORM\Column]
    private ?int $nbPages = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $PublishedAt = null;

    #[ORM\Column]
    private ?int $nbCopy = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editor $editor = null;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Emprunt::class)]
    private Collection $Exemplaire;

    public function __construct()
    {
        $this->Exemplaire = new ArrayCollection();
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

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getNbPages(): ?int
    {
        return $this->nbPages;
    }

    public function setNbPages(int $nbPages): static
    {
        $this->nbPages = $nbPages;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->PublishedAt;
    }

    public function setPublishedAt(\DateTimeImmutable $PublishedAt): static
    {
        $this->PublishedAt = $PublishedAt;

        return $this;
    }

    public function getNbCopy(): ?int
    {
        return $this->nbCopy;
    }

    public function setNbCopy(int $nbCopy): static
    {
        $this->nbCopy = $nbCopy;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

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
     * @return Collection<int, Emprunt>
     */
    public function getExemplaire(): Collection
    {
        return $this->Exemplaire;
    }

    public function addExemplaire(Emprunt $exemplaire): static
    {
        if (!$this->Exemplaire->contains($exemplaire)) {
            $this->Exemplaire->add($exemplaire);
            $exemplaire->setBook($this);
        }

        return $this;
    }

    public function removeExemplaire(Emprunt $exemplaire): static
    {
        if ($this->Exemplaire->removeElement($exemplaire)) {
            // set the owning side to null (unless already changed)
            if ($exemplaire->getBook() === $this) {
                $exemplaire->setBook(null);
            }
        }

        return $this;
    }
}
