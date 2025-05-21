<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Livre;

class LivreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10; $i++)
        {
            $livre = new Livre();
            $livre->setTitre("titre$i");
            $livre->setAuteur("auteur$i");
            $livre->setDateEdition(new \DateTime('2025-05-22'));
            $livre->setCategorie("categorie$i");
            $livre->setDisponibilite((bool)rand(0, 1));
            $manager->persist($livre);
        }

        $manager->flush();
    }
}
