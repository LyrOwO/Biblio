<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BibliController extends AbstractController
{
    #[Route('/', name: 'app_bibli')]
    public function index(): Response
    {
        return $this->render('bibli/index.html.twig', [
            'controller_name' => 'BibliController',
        ]);
    }
}
