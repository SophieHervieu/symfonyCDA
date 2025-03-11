<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Clé primaire')->hideOnForm(),
            TextField::new('title', 'Titre'),
            TextAreaField::new('content', 'Contenu')->setMaxLength(30)->setNumOfRows(30),
            DateTimeField::new('createAt', 'Date')->setFormat('dd-mm-YYYY'),
            AssociationField::new('author', 'Auteur')->autocomplete()->hideOnIndex(),
            AssociationField::new('categories', 'Catégorie')->autocomplete()->hideOnIndex(),
        ];
    }
}
