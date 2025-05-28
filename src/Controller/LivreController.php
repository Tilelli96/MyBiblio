<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreForm;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Reservation;
use Symfony\Component\Validator\Constraints\DateTime;

#[Route('/livre')]
final class LivreController extends AbstractController
{
    #[Route('/index', name: 'app_livre_index', methods: ['GET'])]
    public function index(LivreRepository $livreRepository, Request $request): Response
    {
        $categorie = $request->query->get('categorie');
        $titre = $request->query->get('titre');
        $auteur = $request->query->get('auteur');

        return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->findByRecherche($categorie, $titre, $auteur),
        ]);
    }

    #[Route('/{id}', name: 'app_livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    #[Route('/{id}/reserver', name: 'app_livre_reserver', methods: ['GET'])]
    public function reserver(Livre $livre, EntityManagerInterface $em): Response
    {
        $reservation = new Reservation();
        $reservation->addLivre($livre);
        $reservation->setLecteur($this->getUser());
        $reservation->setDateReservation(new \DateTime());
        $reservation->setStatut("en attente");
        $em->persist($reservation);
        $em->flush();
        $this->addFlash('success', 'votre reservatin a bien été prise en compte');
        return $this->redirectToRoute('app_livre_index');
    }
}
