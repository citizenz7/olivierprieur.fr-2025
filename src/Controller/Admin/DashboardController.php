<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Setting;
use App\Entity\Category;
use App\Entity\Formation;
use App\Entity\Portfolio;
use App\Entity\Experience;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        ->setTitle('<div style="margin: 0 10px 0 0;"><h1 style="font-size: clamp(29px, 3vw, 38px); font-weight: bold; text-align: center; color: #fff;">OP Portfolio</h1><hr style="color: #fff;"></div>')
        ->renderContentMaximized();
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if (!$user instanceof User) {
            throw new \Exception('Mauvais utilisateur.');
        }

        $image = 'uploads/img/users/' . $user->getImage();

        return parent::configureUserMenu($user)
            ->setAvatarUrl($image);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Visiter le site', 'fas fa-home', $this->generateUrl('app_home'));
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-cog');

        // -------------------------------------
        // SECTIONS
        // -------------------------------------
        yield MenuItem::section('Formations & expériences')->setCssClass('text-warning fw-bold shadow');
        yield MenuItem::linkToCrud('Formations', 'fas fa-graduation-cap', Formation::class);
        yield MenuItem::linkToCrud('Expériences', 'fas fa-briefcase', Experience::class);

        yield MenuItem::section('Portfolio')->setCssClass('text-warning fw-bold shadow');
        yield MenuItem::linkToCrud('Catégories', 'fas fa-tags', Category::class);
        yield MenuItem::linkToCrud('Portfolio', 'fas fa-briefcase', Portfolio::class);

        // -------------------------------------
        // PARAMETRES
        // -------------------------------------
        yield MenuItem::section('Paramètres du site')->setCssClass('text-warning fw-bold shadow');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Configuration du site', 'fa fa-cogs', Setting::class);
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addAssetMapperEntry('admin');
    }
}
