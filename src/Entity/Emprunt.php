<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EmpruntRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmpruntRepository::class)]
#[ApiResource]
class Emprunt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateLoan = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateReturn = null;

    #[ORM\ManyToOne(inversedBy: 'Exemplaire')]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'exemplaire')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLoan(): ?\DateTimeImmutable
    {
        return $this->dateLoan;
    }

    public function setDateLoan(\DateTimeImmutable $dateLoan): static
    {
        $this->dateLoan = $dateLoan;

        return $this;
    }

    public function getDateReturn(): ?\DateTimeImmutable
    {
        return $this->dateReturn;
    }

    public function setDateReturn(\DateTimeImmutable $dateReturn): static
    {
        $this->dateReturn = $dateReturn;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
