<?php

namespace App\Controller\Admin;

use App\Entity\GeneralCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GeneralCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GeneralCategory::class;
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
