<?php

namespace App\Controller\Admin;

use App\Entity\Setting;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SettingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Setting::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Général')
                ->setIcon('fas fa-info')
                ->setHelp('Informations générales'),
            FormField::addPanel('Titre'),
            TextField::new('siteName', 'Titre site')
                ->setColumns(4),
            TextField::new('siteVersion', 'Version site')
                ->setColumns(2),
            FormField::addPanel('Logo'),
            ImageField::new('siteLogo', 'Logo site')
                ->setColumns(6)
                ->setRequired(false)
                ->setBasePath('uploads/img')
                ->setUploadDir('public/uploads/img')
                ->setUploadedFileNamePattern('[name]-[uuid].[extension]'),
            TextField::new('siteSubtitle', 'Titre de présentation')
                ->setColumns(6),
            TextEditorField::new('sitePresentation', 'Présentation site')
                ->setColumns(12)
                ->hideOnIndex()
                ->hideOnDetail(),
            TextareaField::new('sitePresentation', 'Présentation site')
                ->hideOnForm()
                ->hideOnIndex()
                ->setTemplatePath('admin/fields/text.html.twig'),

            FormField::addTab('A propos')
                ->setIcon('fas fa-info')
                ->setHelp('Texte pour A propos'),
            TextEditorField::new('siteAbout', 'A propos site')
                ->setColumns(12)
                ->hideOnIndex()
                ->hideOnDetail(),
            TextareaField::new('siteAbout', 'A propos site')
                ->hideOnForm()
                ->hideOnIndex()
                ->setTemplatePath('admin/fields/text.html.twig'),

            FormField::addTab('Url')
                ->setIcon('fas fa-link')
                ->setHelp('Adresses site'),
            FormField::addPanel('Url'),
            TextField::new('siteUrl', 'Url courte')
                ->setColumns(6),
            TextField::new('siteUrlfull', 'Url complète')
                ->setColumns(6),

            FormField::addTab('Mentions légales')
                ->setIcon('fa-solid fa-balance-scale')
                ->setHelp('Mentions légales du site'),
            TextEditorField::new('siteMentions', 'Mentions légales')
                ->setColumns(12)
                ->hideOnIndex()
                ->hideOnDetail(),
            TextareaField::new('siteMentions', 'Mentions légales')
                ->hideOnForm()
                ->hideOnIndex()
                ->setTemplatePath('admin/fields/text.html.twig'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Paramètres du site')
            ->setPageTitle('detail', 'Paramètres du site')
            ->showEntityActionsInlined(true)
            ->setPageTitle('edit', 'Modifier les paramètres');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function(Action $action){
                return $action->setIcon('fas fa-eye text-info')->setLabel('')->addCssClass('text-dark');
            })
            // On DESACTIVE le bouton DELETE et le bouton NEW
            ->disable(Action::DELETE, Action::NEW)
            ->update(Crud::PAGE_INDEX,Action::EDIT,function(Action $action){
                return $action->setIcon('fas fa-edit text-warning')->setLabel('');
            });
    }
}
