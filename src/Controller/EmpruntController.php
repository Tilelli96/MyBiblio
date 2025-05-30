<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/emprunt')]
final class EmpruntController extends AbstractController
{
    #[Route(name: 'app_emprunt_index', methods: ['GET'])]
    public function index(EmpruntRepository $empruntRepository): Response
    {
        $emprunts = $empruntRepository->findByUser($this->getUser());
        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }

    #[Route('/{id}', name: 'app_emprunt_show', methods: ['GET'])]
    public function show(Emprunt $emprunt): Response
    {
        return $this->render('emprunt/show.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }

    #[Route('/retourner/{id}', name: 'retourner', methods: ['GET'])]
    public function retourner(Emprunt $emprunt, EntityManagerInterface $em): Response
    {
        $emprunt->setStatut('retourné');
        $emprunt->setDateRetour(new \DateTime());
        $livres = $emprunt->getLivre();

        foreach($livres as $livre)
        {
            $livre->setDisponibilite(true);
        }

        $em->persist($emprunt);
        $em->flush();

        return $this->redirectToRoute('app_emprunt_index');
    }
}
