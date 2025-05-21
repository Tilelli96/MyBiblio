<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Utilisateur;

class UtilisateurFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 5; $i++)
        {
            $utilisateur = new Utilisateur();
            //crypter le mot de passe 
            $password = $this->hasher->hashPassword($utilisateur, 'utilisateur');
            $utilisateur->setEmail("utilisateur$i@myBiblio.com");
            $utilisateur->setRoles(["ROLE_LECTEUR"]);
            //donner un mot de passe crypté
            $utilisateur->setPassword($password);
            $utilisateur->setNom("nom$i");
            $utilisateur->setTelephone("0000000000");
            $manager->persist($utilisateur);
        }

        for($i = 0; $i < 5; $i++)
        {
            $bibliothecaire = new Utilisateur();
            //crypter le mot de passe 
            $password = $this->hasher->hashPassword($bibliothecaire, 'bibliothecaire');
            $bibliothecaire->setEmail("bibliothecaire$i@myBiblio.com");
            $bibliothecaire->setRoles(["ROLE_BIBLIOTHECAIRE"]);
            //donner un mot de passe crypté
            $bibliothecaire->setPassword($password);
            $bibliothecaire->setNom("nom$i");
            $bibliothecaire->setTelephone("0000000000");
            $manager->persist($bibliothecaire);
        }

        $adminEmail = 'admin@myBiblio.com';
        $existingAdmin = $manager->getRepository(Utilisateur::class)->findOneBy(['email' => $adminEmail]);
        if(!$existingAdmin)
        {
            $admin = new Utilisateur();
            //crypter le mot de passe 
            $password = $this->hasher->hashPassword($admin, 'admin');
            $admin->setEmail("admin$i@myBiblio.com");
            $admin->setRoles(["ROLE_ADMIN"]);
            //donner un mot de passe crypté
            $admin->setPassword($password);
            $admin->setNom("nom$i");
            $admin->setTelephone("0000000000");
            $manager->persist($admin); 
        }

        $manager->flush();
    }
}
