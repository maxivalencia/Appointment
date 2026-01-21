<?php

namespace App\Controller\Admin;

use App\Entity\DureeLimiteAvantRendezVous;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DureeLimiteAvantRendezVousCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DureeLimiteAvantRendezVous::class;
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
