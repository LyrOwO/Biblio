<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PretRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Book;
use App\Entity\User;

#[ORM\Entity(repositoryClass: PretRepository::class)]
#[ApiResource]
class Pret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_debut_pret = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin_pret = null;

    #[ORM\Column(length: 255)]
    private ?string $name_pret = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'prets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $createdBy = null;

    /**
     * @var Collection<int, BooksUser>
     */
    #[ORM\OneToMany(targetEntity: BooksUser::class, mappedBy: 'pret')]
    private Collection $booksUsers;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'pret')]
    private Collection $books;

    public function __construct()
    {
        $this->booksUsers = new ArrayCollection();
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebutPret(): ?\DateTimeInterface
    {
        return $this->date_debut_pret;
    }

    public function setDateDebutPret(\DateTimeInterface $date_debut_pret): static
    {
        $this->date_debut_pret = $date_debut_pret;

        return $this;
    }

    public function getDateFinPret(): ?\DateTimeInterface
    {
        return $this->date_fin_pret;
    }

    public function setDateFinPret(?\DateTimeInterface $date_fin_pret): static
    {
        $this->date_fin_pret = $date_fin_pret;

        return $this;
    }

    public function getNamePret(): ?string
    {
        return $this->name_pret;
    }

    public function setNamePret(string $name_pret): static
    {
        $this->name_pret = $name_pret;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $user): static
    {
        $this->createdBy = $user;

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
            $booksUser->setPret($this);
        }

        return $this;
    }

    public function removeBooksUser(BooksUser $booksUser): static
    {
        if ($this->booksUsers->removeElement($booksUser)) {
            // set the owning side to null (unless already changed)
            if ($booksUser->getPret() === $this) {
                $booksUser->setPret(null);
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
            $book->setPret($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getPret() === $this) {
                $book->setPret(null);
            }
        }

        return $this;
    }
}
