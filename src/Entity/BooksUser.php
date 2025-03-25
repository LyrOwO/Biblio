<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BooksUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BooksUserRepository::class)]
#[ApiResource]
class BooksUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'booksUsers')]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'booksUsers')]
    private ?User $user = null;

    /**
     * @var Collection<int, Shelve>
     */
    #[ORM\OneToMany(targetEntity: Shelve::class, mappedBy: 'booksUser')]
    private Collection $shelves;

    #[ORM\ManyToOne(inversedBy: 'booksUsers')]
    private ?Pret $pret = null;

    #[ORM\Column]
    private ?bool $available = null;


    public function __construct()
    {
        $this->shelves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Shelve>
     */
    public function getShelves(): Collection
    {
        return $this->shelves;
    }

    public function addShelf(Shelve $shelf): static
    {
        if (!$this->shelves->contains($shelf)) {
            $this->shelves->add($shelf);
            $shelf->setBooksUser($this);
        }

        return $this;
    }

    public function removeShelf(Shelve $shelf): static
    {
        if ($this->shelves->removeElement($shelf)) {
            // set the owning side to null (unless already changed)
            if ($shelf->getBooksUser() === $this) {
                $shelf->setBooksUser(null);
            }
        }

        return $this;
    }

    public function getPret(): ?Pret
    {
        return $this->pret;
    }

    public function setPret(?Pret $pret): static
    {
        $this->pret = $pret;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): static
    {
        $this->available = $available;

        return $this;
    }
}
