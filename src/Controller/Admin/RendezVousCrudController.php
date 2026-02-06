<?php

namespace App\Controller\Admin;

use App\Entity\RendezVous;
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
use EasyCorp\Bundle\EasyAdminBundle\Filter\Email;

class RendezVousCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RendezVous::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Rendez-vous')
            ->setEntityLabelInPlural('Rendez-vous')
            ->setSearchFields(['id',
                'immatriculation',
                'proprietaire',
                'contact',
                'mail',
                'adresse',
                'datePriseRendezVous',
                'dateRendezVous',
                'heureRendezVous',
                'confirmation',
                'dateHeureArriveRendezVous',
                'dateHeureFinVisite',
                'dateHeureDebutVisite',
                'annulationRendezVous',
                'dateHeureAnnulationRendezVous',
                'codeRendezVous',
                'dateModificationRendezVous',
                'dateOrigineRendezVous',
                'nombreModification',
                'historiqueRendezVous',
                'centre'
            ])
            ->setDefaultSort(['id' => 'ASC'])
            ->setPaginatorPageSize(20)
            ->setPageTitle(Crud::PAGE_INDEX, 'Appointment - Liste des rendez-vous')
            ->setPageTitle(Crud::PAGE_NEW, 'Appointment - Ajouter un rendez-vous')
            ->setPageTitle(Crud::PAGE_EDIT, 'Appointment - Modifier un rendez-vous')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Appointment - Détails du rendez-vous');
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('immatriculation'))
            ->add(TextFilter::new('proprietaire'))
            ->add(TextFilter::new('contact'))
            ->add(TextFilter::new('mail'))
            ->add(TextFilter::new('adresse'))
            ->add(DateTimeFilter::new('datePriseRendezVous'))
            ->add(DateTimeFilter::new('dateRendezVous'))
            ->add(DateTimeFilter::new('heureRendezVous'))
            ->add(BooleanFilter::new('confirmation'))
            ->add(DateTimeFilter::new('dateHeureArriveRendezVous'))
            ->add(DateTimeFilter::new('dateHeureFinVisite'))
            ->add(DateTimeFilter::new('dateHeureDebutVisite'))
            ->add(TextFilter::new('annulationRendezVous'))
            ->add(DateTimeFilter::new('dateHeureAnnulationRendezVous'))
            ->add(TextFilter::new('codeRendezVous'))
            ->add(DateTimeFilter::new('dateModificationRendezVous'))
            ->add(DateTimeFilter::new('dateOrigineRendezVous'))
            ->add(NumericFilter::new('nombreModification'))
            ->add(EntityFilter::new('historiqueRendezVous'))
            ->add(EntityFilter::new('centre'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('immatriculation'),
            TextField::new('proprietaire'),
            TextField::new('contact'),
            EmailField::new('mail'),
            TextField::new('adresse'),
            DateTimeField::new('datePriseRendezVous'),
            DateField::new('dateRendezVous'),
            TimeField::new('heureRendezVous'),
            BooleanField::new('confirmation'),
            DateTimeField::new('dateHeureArriveRendezVous'),
            DateTimeField::new('dateHeureFinVisite'),
            DateTimeField::new('dateHeureDebutVisite'),
            BooleanField::new('annulationRendezVous'),
            DateTimeField::new('dateHeureAnnulationRendezVous'),
            TextField::new('codeRendezVous'),
            DateTimeField::new('dateModificationRendezVous'),
            DateTimeField::new('dateOrigineRendezVous'),
            IntegerField::new('nombreModification'),
            AssociationField::new('historiqueRendezVous'),
            AssociationField::new('centre'),
        ];
    }

}
