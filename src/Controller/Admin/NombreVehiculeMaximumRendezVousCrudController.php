<?php

namespace App\Controller\Admin;

use App\Entity\NombreVehiculeMaximumRendezVous;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NombreVehiculeMaximumRendezVousCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NombreVehiculeMaximumRendezVous::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
