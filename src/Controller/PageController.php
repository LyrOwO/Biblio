<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="app_bibli")
     */
    public function home(): Response
    {
        return $this->render('book.html.twig');
    }

    /**
     * @Route("/books", name="app_books")
     */
    public function books(): Response
    {
        return $this->render('books.html.twig');
    }

    /**
     * @Route("/shelves", name="app_shelves")
     */
    public function shelves(): Response
    {
        return $this->render('shelves.html.twig');
    }

    /**
     * @Route("/prets", name="app_prets")
     */
    public function prets(): Response
    {
        return $this->render('prets.html.twig');
    }
}
