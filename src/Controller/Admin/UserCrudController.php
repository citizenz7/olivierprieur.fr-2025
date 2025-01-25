<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Validator\Constraints\File;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Infos générales'),
            EmailField::new('email', 'Email')
                ->setColumns(3),
            TextField::new('prenom', 'Prénom')
                ->setColumns(2),
            TextField::new('nom', 'Nom')
                ->setColumns(2),
            TextField::new('telephone', 'Téléphone')
                ->setColumns(2),
            BooleanField::new('status', 'Status emploi')
                ->setColumns(3)
                ->setHelp('Activé : en poste | Desactivé : en recherche d\'emploi'),
            TextField::new('adresse', 'Adresse complète')
                ->setColumns(4),
            ImageField::new('image', 'Image')
                ->setColumns(5)
                ->setBasePath('uploads/img/users')
                ->setUploadDir('public/uploads/img/users')
                ->setRequired(false)
                ->setUploadedFileNamePattern('[name]-[uuid].[extension]'),
            ChoiceField::new('roles', 'Rôle')
                ->setColumns(3)
                ->setChoices([
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'
                ])
                ->allowMultipleChoices()
                ->renderAsBadges([
                    'ROLE_USER' => 'info',
                    'ROLE_ADMIN' => 'success'
                ])
                ->setTemplatePath('admin/roles_displayed_index.html.twig'),

            FormField::addPanel('Texte'),
            TextEditorField::new('apropos', 'A propos')
                ->setColumns(12)
                ->hideOnIndex()
                ->hideOnDetail(),
            TextareaField::new('apropos', 'A propos')
                ->hideOnForm()
                ->hideOnIndex()
                ->setTemplatePath('admin/fields/text.html.twig'),

            FormField::addPanel('CV'),
            ImageField::new('cv', 'CV')
                ->setColumns(6)
                ->setRequired(false)
                ->setBasePath('uploads/files')
                ->setUploadDir('public/uploads/files')
                ->setUploadedFileNamePattern('[name]-[timestamp].[extension]')
                ->hideOnIndex()
                ->hideOnDetail()
                ->setFileConstraints(
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir un fichier PDF',
                        'maxSizeMessage' => 'Veuillez choisir un fichier de 5 Mo maximum',
                    ])
                ),
            TextField::new('cv', 'CV')
                ->setColumns(6)
                ->hideOnForm()
                ->setTemplatePath('admin/fields/documents.html.twig'),

            FormField::addPanel('Socials'),
            TextField::new('linkedin', 'Linkedin')
                ->setColumns(3)
                ->hideonIndex(),
            TextField::new('github', 'Github')
                ->setColumns(3)
                ->hideonIndex(),
            TextField::new('instagram', 'Instagram')
                ->setColumns(3)
                ->hideonIndex(),
            TextField::new('youtube', 'Youtube')
                ->setColumns(3)
                ->hideonIndex(),

        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Liste des utilisateurs')
            ->setPageTitle('edit', 'Modifier un utilisateur')
            ->setPageTitle('detail', 'Fiche de l\'utilisateur')
            ->showEntityActionsInlined(true)
            ->renderContentMaximized()
            ;
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
