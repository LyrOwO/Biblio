<?php

namespace App\Controller;

use App\Repository\ShelveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShelveController extends AbstractController
{
    #[Route('/shelves', name: 'app_shelves')]
    public function index(ShelveRepository $shelveRepository): Response
    {
        $shelves = $shelveRepository->findAll();

        return $this->render('shelves/index.html.twig', [
            'shelves' => $shelves,
        ]);
    }
}
