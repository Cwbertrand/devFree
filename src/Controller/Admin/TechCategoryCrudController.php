<?php

namespace App\Controller\Admin;

use App\Entity\TechCategory;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class TechCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TechCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('tech_cat_name'),
            AssociationField::new('gen_cat'),
        ];
    }
}
