<?php

namespace App\Controller;

use App\Entity\Shelve;
use App\Entity\Book;
use App\Form\ShelveType;
use App\Repository\ShelveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShelveController extends AbstractController
{
    #[Route('/shelves', name: 'app_shelves')]
    public function index(ShelveRepository $shelveRepository): Response
    {
        $user = $this->getUser();
        $shelves = $shelveRepository->findBy(['owner' => $user]); // Fetch shelves owned by the logged-in user

        return $this->render('shelves/index.html.twig', [
            'shelves' => $shelves,
        ]);
    }

    #[Route('/shelves/new', name: 'app_shelves_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $shelve = new Shelve();
        $form = $this->createForm(ShelveType::class, $shelve);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $shelve->setOwner($this->getUser()); // Set the logged-in user as the owner
            $entityManager->persist($shelve);
            $entityManager->flush();

            return $this->redirectToRoute('app_shelves');
        }

        return $this->render('shelves/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/shelves/{id}', name: 'app_shelves_view')]
    public function view(Shelve $shelve): Response
    {
        $this->denyAccessUnlessGranted('view', $shelve);

        return $this->render('shelves/view.html.twig', [
            'shelve' => $shelve,
            'books' => $shelve->getBooksUser()->getBook(),
        ]);
    }

    #[Route('/shelves/delete/{id}', name: 'app_shelves_delete', methods: ['POST'])]
    public function delete(Shelve $shelve, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('delete', $shelve);

        $entityManager->remove($shelve);
        $entityManager->flush();

        return $this->redirectToRoute('app_shelves');
    }
}
