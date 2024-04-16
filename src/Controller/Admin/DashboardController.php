<?php

namespace App\Controller\Admin;

use App\Entity\Classe;
use App\Entity\Contact;
use App\Entity\Intervenant;
use App\Entity\Matiere;
use App\Entity\Review;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ClasseCrudController::class)->generateUrl());


        // Option 2. You can make your dashboard redirect to different pages depending on the makeadminview
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ratemyintervenant');
    }

    public function configureMenuItems(): iterable
    {
       // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Classes', 'fa-solid fa-school', Classe::class);
        yield MenuItem::linkToCrud('Intervenants', 'fa-solid fa-chalkboard-user', Intervenant::class);
        yield MenuItem::linkToCrud('Matieres', 'fa-solid fa-book', Matiere::class);
        yield MenuItem::linkToCrud('Users', 'fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('Reviews', 'fa-regular fa-star', Review::class);
        yield MenuItem::linkToCrud('Contacts', 'fa-solid fa-school', Contact::class);
        yield MenuItem::linkToUrl('Retour au site', 'fas fa-home', $this->generateUrl('app_home'));

    }
}
