<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\ShelveRepository;
use App\Repository\PretRepository;
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
    public function index(
        BookRepository $bookRepository,
        ShelveRepository $shelveRepository,
        PretRepository $pretRepository
    ): Response
    {
        $user = $this->getUser();

        // Livres de l'utilisateur (4 aléatoires)
        $books = $bookRepository->findBy(['addedBy' => $user]);
        shuffle($books);
        $books = array_slice($books, 0, 4);

        // 2 étagères de l'utilisateur
        $shelves = $shelveRepository->findBy(['owner' => $user], null, 2);

        // 2 prêts de l'utilisateur
        $prets = $pretRepository->findBy(['createdBy' => $user], null, 2);

        return $this->render('bibli/index.html.twig', [
            'books' => $books,
            'shelves' => $shelves,
            'prets' => $prets,
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