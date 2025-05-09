<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Pret;
use App\Entity\Book;
use App\Entity\Shelve;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
/**A User. */
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var Collection<int, BooksUser>
     */
    #[ORM\OneToMany(targetEntity: BooksUser::class, mappedBy: 'user')]
    private Collection $booksUsers;

    /**
     * @var Collection<int, Pret>
     */
    #[ORM\OneToMany(targetEntity: Pret::class, mappedBy: 'createdBy')]
    private Collection $prets;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'addedBy')]
    private Collection $books;

    /**
     * @var Collection<int, Shelve>
     */
    #[ORM\OneToMany(targetEntity: Shelve::class, mappedBy: 'owner', cascade: ['persist', 'remove'])]
    private Collection $shelves;

    public function __construct()
    {
        $this->booksUsers = new ArrayCollection();
        $this->prets = new ArrayCollection();
        $this->books = new ArrayCollection();
        $this->shelves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
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
     * @return Collection<int, BooksUser>
     */
    public function getBooksUsers(): Collection
    {
        return $this->booksUsers;
    }

    public function addBooksUser(BooksUser $booksUser): static
    {
        if (!$this->booksUsers->contains($booksUser)) {
            $this->booksUsers->add($booksUser);
            $booksUser->setUser($this);
        }

        return $this;
    }

    public function removeBooksUser(BooksUser $booksUser): static
    {
        if ($this->booksUsers->removeElement($booksUser)) {
            // set the owning side to null (unless already changed)
            if ($booksUser->getUser() === $this) {
                $booksUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pret>
     */
    public function getPrets(): Collection
    {
        return $this->prets;
    }

    public function addPret(Pret $pret): static
    {
        if (!$this->prets->contains($pret)) {
            $this->prets->add($pret);
            $pret->setCreatedBy($this);
        }

        return $this;
    }

    public function removePret(Pret $pret): static
    {
        if ($this->prets->removeElement($pret)) {
            // set the owning side to null (unless already changed)
            if ($pret->getCreatedBy() === $this) {
                $pret->setCreatedBy(null);
            }
        }

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
            $book->setAddedBy($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getAddedBy() === $this) {
                $book->setAddedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Shelve>
     */
    public function getShelves(): Collection
    {
        return $this->shelves;
    }

    public function addShelve(Shelve $shelve): static
    {
        if (!$this->shelves->contains($shelve)) {
            $this->shelves->add($shelve);
            $shelve->setOwner($this);
        }

        return $this;
    }

    public function removeShelve(Shelve $shelve): static
    {
        if ($this->shelves->removeElement($shelve)) {
            // set the owning side to null (unless already changed)
            if ($shelve->getOwner() === $this) {
                $shelve->setOwner(null);
            }
        }

        return $this;
    }
}
