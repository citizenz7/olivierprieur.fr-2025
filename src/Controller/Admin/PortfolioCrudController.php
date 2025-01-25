<?php

namespace App\Controller\Admin;

use App\Entity\Portfolio;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PortfolioCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Portfolio::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // IdField::new('id'),
            TextField::new('title', 'Titre')
                ->setColumns(6),
            SlugField::new('slug', 'Slug')
                ->setTargetFieldName('title')
                ->hideOnIndex()
                ->setColumns(6),
            AssociationField::new('categories', 'Categories')
                ->setColumns(6)
                ->formatValue(function ($value, $entity) {
                    return implode(", ",$entity->getCategories()->toArray());
                }),
            DateField::new('createdAt', 'Date de création')
                ->setColumns(2),
            TextField::new('filter', 'Filtre')
                ->setColumns(2),
            TextField::new('techno', 'Technologie')
                ->setColumns(2),
            ImageField::new('image', 'Image')
                ->setColumns(6)
                ->setRequired(false)
                ->setBasePath('uploads/img/portfolio')
                ->setUploadDir('public/uploads/img/portfolio')
                ->setUploadedFileNamePattern('[name]-[uuid].[extension]'),
            TextField::new('url', 'URL')
                ->setColumns(6),
            TextEditorField::new('presentation', 'Présentation')
                ->setColumns(12)
                ->hideOnIndex()
                ->hideOnDetail(),
            TextareaField::new('presentation', 'Présentation')
                ->hideOnForm()
                ->hideOnIndex()
                ->setTemplatePath('admin/fields/text.html.twig'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des fiches Portfolio')
            ->setPageTitle('edit', 'Modifier une fiche')
            ->setPageTitle('new', 'Ajouter une fiche')
            ->setPageTitle('detail', 'Fiche')
            ->setDefaultSort(['id' => 'DESC'])
            ->setEntityLabelInPlural('Fiches')
            ->setEntityLabelInSingular('Fiche')
            ->showEntityActionsInlined(true)
            ->setPaginatorPageSize(10);
    }

    public function configureActions(Actions $actions): Actions{
        $user = $this->getUser();

        return $actions
            // ->update(Crud::PAGE_INDEX,Action::NEW,function(Action $action){
            //     return $action->setIcon('fas fa-tags pe-1')->setLabel('Ajouter un article');
            // })
            // on n'affiche pas le bouton "Ajouter un article" si l'adresse e-mail n'est pas confirmée
            ->update(Crud::PAGE_INDEX,Action::NEW,function(Action $action){
                return $action->setIcon('fas fa-tags pe-1')->setLabel('Ajouter une fiche');
            })
            ->update(Crud::PAGE_INDEX,Action::EDIT,function(Action $action){
                return $action->setIcon('fas fa-edit text-warning')->setLabel('');
            })
            ->add(Crud::PAGE_INDEX,Action::DETAIL)
            ->update(Crud::PAGE_INDEX,Action::DETAIL,function(Action $action){
                return $action->setIcon('fas fa-eye text-info')->setLabel('');
            })
            ->update(Crud::PAGE_INDEX,Action::DELETE,function(Action $action){
                return $action->setIcon('fas fa-trash text-danger')->setLabel('');
            });
    }
}
