<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Utilisateur;
use App\Entity\Livre;
use App\Entity\Reservation;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $utilisateurs = $manager->getRepository(Utilisateur::class)->findAll();
        $livres = $manager->getRepository(Livre::class)->findAll();
        $statuts = ['validée', 'en cours', 'refusée'];
        foreach($utilisateurs as $utilisateur)
        {
            $reservation = new Reservation();
            $reservation->addLivre($livres[array_rand($livres)]);
            $reservation->setLecteur($utilisateurs[array_rand($utilisateurs)]);
            $reservation->setDateReservation(new \DateTime('2025-05-22'));
            $reservation->setStatut($statuts[rand(1,3) % count($statuts)]);
            $manager->persist($reservation);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UtilisateurFixtures::class,
            LivreFixtures::class,
        ];
    }
}
