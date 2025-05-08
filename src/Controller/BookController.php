<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/books', name: 'app_books')]
    public function index(BookRepository $bookRepository): Response
    {
        $user = $this->getUser();
        $books = $bookRepository->findBy(['addedBy' => $user]);

        return $this->render('books/index.html.twig', [
            'books' => $books,
        ]);
    }
}
