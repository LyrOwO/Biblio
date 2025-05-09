<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;

class BibliController extends AbstractController
{

    public function __construct(
        private HttpClientInterface $client,
        private EntityManagerInterface $entityManager,
    ) {
    }


    #[Route('/', name: 'app_bibli')]
    public function index(BookRepository $bookRepository): Response
    {
        $user = $this->getUser(); // Get the currently logged-in user
        $books = $bookRepository->findBy(['addedBy' => $user]); // Fetch books added by the logged-in user

        return $this->render('bibli/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/books', name: 'app_books')]
    public function books(BookRepository $BookRepository): Response
    {
        $books = $BookRepository->findAll();

        return $this->render('bibli/books.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/shelves', name: 'app_shelves')]
    public function shelves(): Response
    {
        return $this->render('bibli/shelves.html.twig');
    }

    #[Route('/prets', name: 'app_prets')]
    public function prets(): Response
    {
        return $this->render('bibli/prets.html.twig');
    }
}