# portfolio OP 2025
Portfolio Olivier Prieur 2025

### Environnement
* Symfony 7.2
* PHP 8.3+
* Composer 2
* AssetMapper

### ADMIN/BackOffice
* Url : /admin

### BUNDLES
* easycorp/easyadmin-bundle
* symfony/asset-mapper
* knplabs/knp-paginator-bundle
* victor-prdh/recaptcha-bundle
* twig/intl-extra
* ...

### Fonts
* Poppins (body)
* Raleway (title)
* Satisfy (gros titre)

### Sweet Alert2
`php bin/console importmap:require sweetalert2`

### COMMANDES
* commande Symfony pour la création d'un admin :
`php bin/console app:create-admin EMAIL PASSWORD PRENOM NOM`

### Listener (EventSubscriber is deprecated)
`symfony console make:listener EasyAdminSubscriberOfficeCreatedAt`

### Translations (format yaml, plus lisible)
`symfony console translation:extract --force fr --format yaml`

### Créer un mot de passe hashé en console
`symfony console security:hash-password`

### AssetMapper
* Installer un package JS (exemple avec SplideJS) : `php bin/console importmap:require @splidejs/splide`
* Vérifier les mises à jour éventuelles de tous les packages JS installés : `php bin/console importmap:outdated`
* Vérifier les mises à jour pour un package JS en particulier : `php bin/console importmap:outdated @splidejs/splide`

### Mise en PROD
1. `php bin/console importmap:install` : resinstaller les fichiers JS sur un autre serveur
2. `php bin/console asset-map:compile` : compiler les assets dans public **à chaque fois** qu'il y a un changement de fichier CSS

### A FAIRE / VERIFIER AVANT LA MISE EN PROD
* ~~page login CSS~~
* ~~Erreurs personnalisées~~
* ~~reCaptcha Google~~
* ~~test formulaire de contact~~
* ~~flash messages~~
* ~~BO css~~
* ~~Sitemap - Ajouter sitemap dans robots.txt : `Sitemap: https://www.monsite.fr/sitemap.xml`~~
* ~~robots.txt~~
* ~~Google Analytics 4~~
* Google Search Console + soumission sitemap
* ~~Favicon~~
* ~~Meta + données structurées schema.org~~
* ~~Tarteaucitron~~
* ~~permissions BO : utilisateurs, commentaires, articles, images, fichiers~~
* ~~div dans les crudcontroller ADMIN~~
* ~~Responsive~~
* ~~CGU~~
* ~~Confidentialite~~
* ~~constraints dans crud controller sur images et fichiers~~
* ~~Mentions légales~~