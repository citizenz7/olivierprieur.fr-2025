<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\CategoryRepository;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use App\Repository\SettingRepository;
use App\Repository\FormationRepository;
use App\Repository\ExperienceRepository;
use App\Repository\PortfolioRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        SettingRepository $settingRepository,
        ExperienceRepository $experienceRepository,
        FormationRepository $formationRepository,
        UserRepository $userRepository,
        PortfolioRepository $portfolioRepository,
        CategoryRepository $categoryRepository,
        Request $request,
        MailerInterface $mailer
    ): Response
    {
        $settings = $settingRepository->findOneBy([]);
        $experiences = $experienceRepository->findBy([], ['date' => 'DESC']);
        $formations = $formationRepository->findBy([], ['date' => 'DESC']);
        $user = $userRepository->findOneBy(['id' => 1]);
        $portfolios = $portfolioRepository->findBy([], ['createdAt' => 'DESC']);
        $categories = $categoryRepository->findAll();

        $siteEmail = $settings->getSiteEmail();
        $siteName = $settings->getSiteName();

        // Blog RSS
        $rssUrl = 'https://www.citizenz.info/rss';
        $xml = simplexml_load_file($rssUrl);

        $articles = [];
        foreach ($xml->channel->item as $item) {
            $article = [
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'description' => (string) $item->description,
                'pubDate' => (string) $item->pubDate,
            ];
            $articles[] = $article;
        }

        // Contact
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            $email = (new Email())
            ->from($siteEmail)
            ->to(new Address($siteEmail, $siteName))
            ->subject('Message depuis votre site web : '. $siteName)
            ->html(
                '<h4 style="color: #007bff;">Message envoyé depuis le site web : '. $siteName . '</h4>' .
                '<span style="color: #007bff; font-weight: bold;">De :</span> ' . $contactFormData['nom'] . '<br>' .
                '<span style="font-weight: bold; color: #007bff;">E-mail :</span> ' . $contactFormData['email'] . '<br>' .
                '<p><span style="font-weight: bold; color: #007bff;">Message</span> : <br>' . trim(nl2br($contactFormData['message'])) . '</p>',
                'text/plain'
            );

            try {
                $mailer->send($email);

                $this->addFlash('sendmailsuccess', 'Le message a bien été envoyé !');

                // return $this->redirect(
                //     $this->generateUrl('app_home') . '#sendmailsuccess'
                // );
                return $this->redirectToRoute('app_home');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi du message !');
            }
        }

        return $this->render('home/index.html.twig', [
            'settings' => $settings,
            'experiences' => $experiences,
            'formations' => $formations,
            'user' => $user,
            'form' => $form,
            'articles' => $articles,
            'portfolios' => $portfolios,
            'categories' => $categories,
            'current_menu' => 'home',
        ]);
    }

    #[Route('/mentions-legales', name: 'app_mentions')]
    public function mentions(
        SettingRepository $settingRepository,
        UserRepository $userRepository
    ): Response
    {
        $settings = $settingRepository->findOneBy([]);
        $user = $userRepository->findOneBy(['id' => 1]);

        return $this->render('home/mentions.html.twig', [
            'settings' => $settings,
            'user' => $user,
        ]);
    }

    #[Route('/sitemap.xml', name: 'app_sitemap', defaults: ['_format', 'xml'])]
    public function sitemap(
        Request $request,
        SettingRepository $settingRepository,
        // UserRepository $userRepository
    ): Response {
        $settings = $settingRepository->findOneBy([]);
        // $user = $userRepository->findOneBy(['id' => 1]);

        $hostname = $request->getSchemeAndHttpHost();
        $lastmodPage = date('Y-m-d');

        // Initialisation du tableau des URL
        $urls = [];

        // Homepage
        $urls[] = [
            'loc' => $this->generateUrl('app_home'),
            'lastmod' => $lastmodPage,
            'changefreq' => 'weekly',
            'priority' => '0.5',
        ];

        // Mentions légales
        $urls[] = [
            'loc' => $this->generateUrl('app_mentions'),
            'lastmod' => $lastmodPage,
            'changefreq' => 'weekly',
            'priority' => '0.5',
        ];

        // Create the XML response
        $response = new Response(
            $this->renderView('home/sitemap.html.twig', [
                'urls' => $urls,
                'hostname' => $hostname,
                'settings' => $settings,
                // 'user' => $user,
            ]),
            200
        );

        // Add headers
        $response->headers->set('Content-Type', 'application/xml');

        // Send the response
        return $response;
    }
}
