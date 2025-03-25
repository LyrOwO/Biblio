<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[UniqueEntity('ISBN')]
#[ApiResource]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    /**
     * @var Collection<int, BooksUser>
     */
    #[ORM\OneToMany(targetEntity: BooksUser::class, mappedBy: 'book')]
    private Collection $booksUsers;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ImageLinkMedium = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ImageLinkThumbnail = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $IndustryIdentifiersIdentifier = null;

    #[ORM\Column(nullable: true)]
    private ?int $pageCount = null;

    /**
     * @var Collection<int, Author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    private Collection $authors;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Author::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: true)] // Changez nullable à true
    private ?Author $author = null;

    #[ORM\Column(length: 13, unique: true, nullable: true)]
    private ?string $ISBN = null;

    public function __construct()
    {
        $this->booksUsers = new ArrayCollection();
        $this->authors = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getTitle();
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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

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
            $booksUser->setBook($this);
        }

        return $this;
    }

    public function removeBooksUser(BooksUser $booksUser): static
    {
        if ($this->booksUsers->removeElement($booksUser)) {
            // set the owning side to null (unless already changed)
            if ($booksUser->getBook() === $this) {
                $booksUser->setBook(null);
            }
        }

        return $this;
    }

    public function getImageLinkMedium(): ?string
    {
        return $this->ImageLinkMedium;
    }

    public function setImageLinkMedium(?string $ImageLinkMedium): static
    {
        $this->ImageLinkMedium = $ImageLinkMedium;

        return $this;
    }

    public function getImageLinkThumbnail(): ?string
    {
        return $this->ImageLinkThumbnail;
    }

    public function setImageLinkThumbnail(?string $ImageLinkThumbnail): static
    {
        $this->ImageLinkThumbnail = $ImageLinkThumbnail;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }



    public function getIndustryIdentifiersIdentifier(): ?string
    {
        return $this->IndustryIdentifiersIdentifier;
    }

    public function setIndustryIdentifiersIdentifier(?string $IndustryIdentifiersIdentifier): static
    {
        $this->IndustryIdentifiersIdentifier = $IndustryIdentifiersIdentifier;

        return $this;
    }

    public function getPageCount(): ?int
    {
        return $this->pageCount;
    }

    public function setPageCount(?int $pageCount): static
    {
        $this->pageCount = $pageCount;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        $this->authors->removeElement($author);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDisplaySubtitle(): string {
        if(!empty($this->getSubtitle())) 
            return $this->getSubtitle();

        if(!empty($this->getTitle()))
            $titleWords = explode(' ', $this->getTitle());
            $excerpt = implode(' ', array_slice($titleWords, 0, 5));
            return $excerpt;
        
        return '';
        
    }

    public function getDisplayImage(): string {
        if(!empty($this->getImageLinkMedium()))
            return $this->getImageLinkMedium();

        if(!empty($this->getImageLinkThumbnail()))
            return $this->getImageLinkThumbnail();

        return 'bibliotheme\assets\images\item1.png';
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        if ($author === null) {
            // Récupérez l'auteur par défaut (ID = 1)
            $defaultAuthor = new Author();
            $defaultAuthor->setId(4); // Assurez-vous que l'ID correspond à l'auteur par défaut
            $defaultAuthor->setName('Auteur inconnu');
            $this->author = $defaultAuthor;
        } else {
            $this->author = $author;
        }

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(?string $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }
   

}
