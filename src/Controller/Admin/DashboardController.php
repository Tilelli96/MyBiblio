<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Utilisateur;
use App\Entity\Livre;
use App\Entity\Reservation;
use App\Entity\Emprunt;

#[AdminDashboard(routePath: '/gestion', routeName: 'gestion')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MyBiblio');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        //yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-list', Utilisateur::class);
        yield MenuItem::linkToCrud('Livres', 'fas fa-book', Livre::class);
        //yield MenuItem::linkToCrud('emprunts', 'fas fa-handshake', Emprunt::class);
        //yield MenuItem::linkToCrud('reservations', 'fas fa-handshake', Reservation::class);
        yield MenuItem::linkToRoute('Application', 'fa-solid fa-browser', 'app_login');
        yield MenuItem::linkToLogout('Logout', 'fa fa-exit');
    }
}
