<?php
namespace App\Controller;

use App\Entity\Pret;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PretsController extends AbstractController
{
    #[Route('/prets/delete/{id}', name: 'app_prets_delete', methods: ['POST'])]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $pret = $entityManager->getRepository(Pret::class)->find($id);

        if (!$pret) {
            $this->addFlash('error', 'Prêt not found.');
            return $this->redirectToRoute('app_prets');
        }

        $entityManager->remove($pret);
        $entityManager->flush();

        $this->addFlash('success', 'Prêt deleted successfully.');
        return $this->redirectToRoute('app_prets');
    }
}