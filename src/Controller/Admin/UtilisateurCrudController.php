<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\SecurityBundle\Security;

class UtilisateurCrudController extends AbstractCrudController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Utilisateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('nom'),
            EmailField::new('email'),
            TextField::new('telephone'),
        ];

        // Montrer le champ des rôles uniquement pour les admins
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $fields[] = ChoiceField::new('roles')
                ->setChoices([
                    'Lecteur' => 'ROLE_LECTEUR',
                    'Bibliothécaire' => 'ROLE_BIBLIOTHECAIRE',
                    'Admin' => 'ROLE_ADMIN',
                ])
                ->allowMultipleChoices()
                ->renderExpanded();
        } else {
            // Le bibliothécaire peut seulement affecter ROLE_LECTEUR
            $fields[] = ChoiceField::new('roles')
                ->setChoices([
                    'Lecteur' => 'ROLE_LECTEUR',
                ])
                ->allowMultipleChoices()
                ->renderExpanded();
        }

        return $fields;
    }
}
