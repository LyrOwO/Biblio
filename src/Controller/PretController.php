<?php

namespace App\Controller;

use App\Entity\Pret;
use App\Form\PretType;
use App\Repository\PretRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PretController extends AbstractController
{
    #[Route('/prets', name: 'app_prets')]
    public function index(PretRepository $pretRepository): Response
    {
        $user = $this->getUser();
        $prets = $pretRepository->findBy(['createdBy' => $user]);

        return $this->render('prets/index.html.twig', [
            'prets' => $prets,
        ]);
    }

    #[Route('/prets/new', name: 'app_prets_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pret = new Pret();
        $pret->setCreatedBy($this->getUser());
        $form = $this->createForm(PretType::class, $pret);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pret);
            $entityManager->flush();

            return $this->redirectToRoute('app_prets');
        }

        return $this->render('prets/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
