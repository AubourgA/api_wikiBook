<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string')]
    private string $password;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(type: 'integer')]
    private ?int $cityCode = null;

    #[ORM\Column(type:'datetime_immutable')]
    private ?\DateTimeImmutable $createdAt = null;

    private $plainpassword = null;

    #[ORM\Column(type: 'boolean', nullable:false)]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Emprunt::class)]
    private Collection $exemplaire;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->exemplaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCityCode(): ?int
    {
        return $this->cityCode;
    }

    public function setCityCode(int $cityCode): static
    {
        $this->cityCode = $cityCode;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of plainpassword
     */ 
    public function getPlainpassword()
    {
        return $this->plainpassword;
    }

    /**
     * Set the value of plainpassword
     *
     * @return  self
     */ 
    public function setPlainpassword($plainpassword)
    {
        $this->plainpassword = $plainpassword;

        return $this;
    }

       /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getExemplaire(): Collection
    {
        return $this->exemplaire;
    }

    public function addExemplaire(Emprunt $exemplaire): static
    {
        if (!$this->exemplaire->contains($exemplaire)) {
            $this->exemplaire->add($exemplaire);
            $exemplaire->setUser($this);
        }

        return $this;
    }

    public function removeExemplaire(Emprunt $exemplaire): static
    {
        if ($this->exemplaire->removeElement($exemplaire)) {
            // set the owning side to null (unless already changed)
            if ($exemplaire->getUser() === $this) {
                $exemplaire->setUser(null);
            }
        }

        return $this;
    }
}
