<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\Developer;
use App\Entity\Experience;
use App\Entity\GeneralCategory;
use App\Entity\Language;
use App\Entity\TechCategory;
use App\Entity\Technology;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('Admin/admin_base.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DevFree');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        //Configure the site
        yield MenuItem::section('CONFIGURATION');
        yield MenuItem::linkToRoute('General Configuration', 'fa fa-table-columns', 'admin_site_config');
        yield MenuItem::linkToRoute('Configuration de Societé', 'fa-solid fa-gear', 'admin_societe_config');

        yield MenuItem::section('USER');
        yield MenuItem::linkToCrud('Client', 'fas fa-list', Client::class);
        yield MenuItem::linkToCrud('Developer', 'fas fa-list', Developer::class);
        yield MenuItem::linkToCrud('Experience', 'fas fa-list', Experience::class);
        yield MenuItem::linkToCrud('Language', 'fas fa-list', Language::class);
        yield MenuItem::linkToCrud('Technology', 'fas fa-list', Technology::class);
        yield MenuItem::linkToCrud('Tech Category', 'fas fa-list', TechCategory::class);
        yield MenuItem::linkToCrud('General Category', 'fas fa-list', GeneralCategory::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
