<?php

namespace App\Controller\Admin;

use App\Entity\HistoriqueRendezVous;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;

class HistoriqueRendezVousCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HistoriqueRendezVous::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Historique de rendez-vous')
            ->setEntityLabelInPlural('Historiques des rendez-vous')
            ->setSearchFields(['id', 'rendezVous'])
            ->setDefaultSort(['id' => 'ASC'])
            ->setPaginatorPageSize(20)
            ->setPageTitle(Crud::PAGE_INDEX, 'Appointment - Liste des historiques rendez-vous')
            ->setPageTitle(Crud::PAGE_NEW, 'Appointment - Ajouter un  historique rendez-vous')
            ->setPageTitle(Crud::PAGE_EDIT, 'Appointment - Modifier un  historique rendez-vous')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Appointment - Détails du  historique rendez-vous');
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        /* return $filters
            ->add(EntityFilter::new('HistoriqueRendezVous'))
        ; */
        return $filters
            ->add(TextFilter::new('rendezVous'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('rendezVous'),
        ];
    }

}
