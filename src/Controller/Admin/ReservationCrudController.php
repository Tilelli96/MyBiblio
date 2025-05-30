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
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

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
            ->linkToCrudAction('validerReservation')
            ->linkToCrudAction('validerReservation', function ($entity) {
                return ['entityId' => $entity->getId()];
                });
        return $actions
            ->add(Crud::PAGE_INDEX, $valider);
    }

    #[Route('/admin/reservation/{id}/valider', name: 'admin_reservation_valider')]
    public function validerReservation(AdminContext $context, EntityManagerInterface $em): Response
    {
        $entityId = $context->getRequest()->query->get('entityId');
        $reservation = $em->getRepository(Reservation::class)->find($entityId);
        $reservation->setStatut('Validée');
        $em->persist($reservation);

        $emprunt = new Emprunt();
        $livres = $reservation->getLivre();
        foreach ($livres as $livre)
        {
            $emprunt->addLivre($livre);
        }
        $emprunt->setLecteur($reservation->getLecteur());
        $emprunt->setDateEmprunt($reservation->getDateReservation());
        $emprunt->setStatut('en cours');
        $em->persist($emprunt);

        $em->flush();

        //revenir à la page EasyAdmin précédente
        return $this->redirect($context->getReferrer());
    }


}
