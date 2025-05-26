<?php

namespace App\Controller\Admin;

use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class EmpruntCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Emprunt::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // pour édition
            AssociationField::new('lecteur', 'Lecteur'),

            //pour affichage lisible
            Field::new('nomLecteur', 'Nom du lecteur')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
                    /** @var \App\Entity\Emprunt $entity */
                    return $entity->getLecteur()?->getNom() ?? 'Inconnu';
                }),

            DateField::new('dateEmprunt', 'Date d\'emprunt'),
            DateField::new('dateRetour', 'Date de retour'),
            TextField::new('statut'),

            // pour édition
            AssociationField::new('livre', 'Livres'),
            Field::new('titresLivres', 'Livres empruntés')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
                    /** @var \App\Entity\Emprunt $entity */
                    $livres = $entity->getLivre();
                    $titres = [];
                    foreach($livres as $livre)
                    {
                        $titres[] = $livre->getTitre();
                    }
                    return implode(', ', $titres);;
                }),
        ];
    }
}
