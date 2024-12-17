<?php

namespace App\Controller\Admin;

use App\Entity\Pret;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
class PretCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pret::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            DateTimeField::new('date_debut_pret'),
            DateTimeField::new('date_fin_pret'),
        ];
    }
    
}
