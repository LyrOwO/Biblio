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
    public function index(BookRepository $BookRepository): Response
    
    {
        /*
        $response = $this->client->request(
            'GET',
            'https://www.googleapis.com/books/v1/volumes?q=Berserk+inauthor:Kentaro Miura'
        );
        $results = $response->toArray();
        if (!empty($results['items'])) {
            foreach ($results['items'] as $item) {
                // Vérifier si 'industryIdentifiers' existe dans 'volumeInfo'
                //if (!empty($item['volumeInfo']['industryIdentifiers'])) {
                    //foreach ($item['volumeInfo']['industryIdentifiers'] as $identifier) {
                        //if (isset($identifier['identifier'])) {
                            //echo $identifier['identifier'] . "\n";
                        //}
                    //}
                //} else {
                    //echo "Pas d'identifiants pour cet élément.\n";
                //}
            
                $book = new Book();
                $book->setTitle($item['volumeInfo']['title']);

                if(!empty($item['volumeInfo']['imageLinks']['medium']))
                    $book->setImageLinkMedium($item['volumeInfo']['imageLinks']['medium']);

                if(!empty($item['volumeInfo']['imageLinks']['thumbnail']))
                    $book->setImageLinkThumbnail($item['volumeInfo']['imageLinks']['thumbnail']);

                
                $book->getDisplaySubtitle($item['volumeInfo']);

                $book->getDisplayImage($item);
                

                $book->setDescription($item['volumeInfo']['description']);

                if (!empty($item['volumeInfo']['industryIdentifiers'])) {
                    $identifierToStore = null;
                
                    // Première boucle : chercher ISBN_13
                    foreach ($item['volumeInfo']['industryIdentifiers'] as $identifier) {
                        if ($identifier['type'] === 'ISBN_13') {
                            // Si ISBN_13 est trouvé, on le garde
                            $identifierToStore = $identifier['identifier'];
                            $book->setIndustryIdentifiersIdentifier($identifierToStore);
                            break; // Sortir de la boucle dès qu'on a trouvé ISBN_13
                        }
                    }
                
                    // Si aucun ISBN_13 trouvé, chercher ISBN_10 avec un elseif
                    if ($identifierToStore === null) {
                        foreach ($item['volumeInfo']['industryIdentifiers'] as $identifier) {
                            if ($identifier['type'] === 'ISBN_10') {
                                // Si ISBN_10 est trouvé, on le garde
                                $identifierToStore = $identifier['identifier'];
                                $book->setIndustryIdentifiersIdentifier($identifierToStore);
                                break; // Sortir de la boucle dès qu'on a trouvé ISBN_10
                            }
                        }
                    }
                
                    // Si aucun ISBN_13 ni ISBN_10 n'a été trouvé, prendre le premier identifiant disponible
                    if ($identifierToStore === null) {
                        $identifierToStore = $item['volumeInfo']['industryIdentifiers'][0]['identifier'];
                        $book->setIndustryIdentifiersIdentifier($identifierToStore);
                    }
                }
                

                
                $book->setPagecount($item['volumeInfo']['pageCount']);
                //$book->set
                $this->entityManager->persist($book);
                $this->entityManager->flush();

            }   
         
        }
        */
        //exit;
        //foreach(
            //var_dump();
            //exit;
        $books = $BookRepository->findAll();

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