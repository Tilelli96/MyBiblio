<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Utilisateur;
use App\Entity\Livre;
use App\Entity\Emprunt;

class EmpruntFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $utilisateurs = $manager->getRepository(Utilisateur::class)->findAll();
        $livres = $manager->getRepository(Livre::class)->findAll();
        $statuts = ['en_cours', 'retourne', 'en_retard'];
        foreach($utilisateurs as $utilisateur)
        {
            $emprunt = new Emprunt();
            $emprunt->addLivre($livres[array_rand($livres)]);
            $emprunt->setLecteur($utilisateurs[array_rand($utilisateurs)]);
            $emprunt->setDateEmprunt(new \DateTime('2025-05-22'));
            $emprunt->setDateRetour(new \DateTime('2025-05-23'));
            $emprunt->setStatut($statuts[rand(1,3) % count($statuts)]);
            $manager->persist($emprunt);
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
