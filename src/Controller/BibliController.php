<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BibliController extends AbstractController
{

    public function __construct(
        private HttpClientInterface $client,
    ) {
    }


    #[Route('/', name: 'app_bibli')]
    public function index(BookRepository $BookRepository): Response
    {

        $response = $this->client->request(
            'GET',
            'https://www.googleapis.com/books/v1/volumes?q=api'
        );
        $results = $response->toArray();
        if(!empty($results['items'])){
            foreach($results['items'] as $item) {
                echo $item["volumeInfo"]['title'].'<br>';
            }
        }
        exit;
        //foreach(
            var_dump();
            exit;
        $books = $BookRepository->findAll();

        return $this->render('bibli/index.html.twig', [
            'books' => $books,
        ]);
    }
}