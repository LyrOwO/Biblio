<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Author;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('author Book')
            ->setEntityLabelInPlural('author Books')
            ->setSearchFields(['title', 'IndustryIdentifiersIdentifier', 'comment', 'ImageLinkMedium', 'ImageLinkThumbnail']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('author'));
    }

    public function configureFields(string $pageName): iterable
    {
        // Debugging Book entity
        // $book = $this->getDoctrine()->getRepository(Book::class)->findAll();
        // dd($book);

        yield AssociationField::new('author');
        yield TextField::new('title');
        yield TextField::new('IndustryIdentifiersIdentifier');
        yield TextareaField::new('comment');
        yield TextField::new('ImageLinkMedium');
        yield TextField::new('ImageLinkThumbnail');
        yield AssociationField::new('addedBy')->setLabel('Added By')->hideOnForm(); // Use AssociationField instead of EntityField
    }

    public function createEntity(string $entityFqcn)
    {
        $book = new $entityFqcn();
        $book->setAddedBy($this->getUser());

        return $book;
    }
}