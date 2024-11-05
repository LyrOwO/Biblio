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
    public function index(BookRepository $BookRepository, AuthorRepository $AuthorRepository): Response
    
    {

        $response = $this->client->request(
            'GET',
            'https://www.googleapis.com/books/v1/volumes?q=api'
        );
        $results = $response->toArray();
        if(!empty($results['items'])){
            foreach($results['items'] as $item) {
                var_dump($item['volumeInfo']['industryIdentifiers']);
                //mettre foreachpour parcourir les valeurs, voir le quel guarder
                exit();
                $book = new Book();
                $book->setTitle($item['volumeInfo']['title']);
                if(!empty($item['volumeInfo']['imageLinks']['medium']))
                    $book->setImageLinkMedium($item['volumeInfo']['imageLinks']['medium']);

                if(!empty($item['volumeInfo']['imageLinks']['thumbnail']))
                    $book->setImageLinkThumbnail($item['volumeInfo']['imageLinks']['thumbnail']);

                //$book->setSubtitle($item['volumeInfo']['subtitle']);
                $book->setDescription($item['volumeInfo']['description']);
                //$book->setIndustryIdentifiersIdentifier($item['volumeInfo']['industryIdentifiers']['identifier']);
                //
                $book->setPagecount($item['volumeInfo']['pageCount']);
                //$book->set
                $this->entityManager->persist($book);
                $this->entityManager->flush();
                


                
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