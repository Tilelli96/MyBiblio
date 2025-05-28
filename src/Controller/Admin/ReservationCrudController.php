<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use App\Entity\Emprunt;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('statut'),
            AssociationField::new('lecteur', 'Lecteur'),
            AssociationField::new('livre', 'Livres'),
            DateField::new('date_reservation', 'Date de reservation')
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $valider = Action::new('valider', 'Valider')
        ->linkToCrudAction('validerReservation');

    return $actions
        ->add(Crud::PAGE_INDEX, $valider);
    }

}
