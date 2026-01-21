<?php

namespace App\Controller\Admin;

use App\Entity\Centres;
use App\Entity\DureeLimiteAvantRendezVous;
use App\Entity\HistoriqueRendezVous;
use App\Entity\JourSpeciale;
use App\Entity\NombreJourMaximumRendezVous;
use App\Entity\NombreModificationMaximum;
use App\Entity\NombreRendezVousParHeure;
use App\Entity\NombreVehiculeMaximumRendezVous;
use App\Entity\OuvertureSamedi;
use App\Entity\Provinces;
use App\Entity\RendezVous;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route(name: 'admin_index')]
    public function index(): Response
    {
        return parent::index();
        /* $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(ConferenceCrudController::class)->generateUrl();

        return $this->redirect($url); */

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Appointment');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        // yield MenuItem::linkToRoute('The Label', 'fas fa-list', 'homepage');
        yield MenuItem::linkToCrud('Centres', 'fas fa-list', Centres::class);
        yield MenuItem::linkToCrud('Durée limite avant rendez-vous', 'fas fa-list', DureeLimiteAvantRendezVous::class);
        yield MenuItem::linkToCrud('Historiques des rendez-vous', 'fas fa-list', HistoriqueRendezVous::class);
        yield MenuItem::linkToCrud('Jours spéciale', 'fas fa-list', JourSpeciale::class);
        yield MenuItem::linkToCrud('Nombre jour maximum', 'fas fa-list', NombreJourMaximumRendezVous::class);
        yield MenuItem::linkToCrud('Nombre modification maximum', 'fas fa-list', NombreModificationMaximum::class);
        yield MenuItem::linkToCrud('Nombre rendez-vous par heure', 'fas fa-list', NombreRendezVousParHeure::class);
        yield MenuItem::linkToCrud('Nombre véhicule par rendez-vous', 'fas fa-list', NombreVehiculeMaximumRendezVous::class);
        yield MenuItem::linkToCrud('Ouverture samedi', 'fas fa-list', OuvertureSamedi::class);
        yield MenuItem::linkToCrud('Provinces', 'fas fa-list', Provinces::class);
        yield MenuItem::linkToCrud('Rendez-vous', 'fas fa-list', RendezVous::class);
    }

    /* public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Conference Comment')
            ->setEntityLabelInPlural('Conference Comments')
            ->setSearchFields(['author', 'text', 'email'])
            ->setDefaultSort(['createdAt' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('conference'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('conference');
        yield TextField::new('author');
        yield EmailField::new('email');
        yield TextareaField::new('text')
            ->hideOnIndex()
        ;
        yield TextField::new('photoFilename')
            ->onlyOnIndex()
        ;

        $createdAt = DateTimeField::new('createdAt')->setFormTypeOptions([
            'years' => range(date('Y'), date('Y') + 5),
            'widget' => 'single_text',
        ]);
        if (Crud::PAGE_EDIT === $pageName) {
            yield $createdAt->setFormTypeOption('disabled', true);
        } else {
            yield $createdAt;
        }
    } */
}
