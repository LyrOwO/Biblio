<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BibliController extends AbstractController
{
    #[Route('/', name: 'app_bibli')]
    public function index(BookRepository $BookRepository): Response
    {
        $books = $BookRepository->findAll();

        return $this->render('bibli/index.html.twig', [
            'books' => $books,
        ]);
    }
}
