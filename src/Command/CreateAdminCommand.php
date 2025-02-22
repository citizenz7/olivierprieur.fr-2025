<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Crée un compte Administrateur',
)]

// Créer un user directement en console :
// php bin/console app:create-admin EMAIL PASSWORD PRENOM NOM

class CreateAdminCommand extends Command
{
    private $entityManagerInterface;
    private $encoder;

    public function __construct(
        EntityManagerInterface $entityManagerInterface,
        UserPasswordHasherInterface $encoder
    ) {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->encoder = $encoder;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('email', InputArgument::REQUIRED, 'E-mail')
            ->addArgument('password', InputArgument::REQUIRED, 'Mot de passe')
            ->addArgument('prenom', InputArgument::REQUIRED, 'Prénom')
            ->addArgument('nom', InputArgument::REQUIRED, 'Nom');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = new User();

        $user->setEmail($input->getArgument('email'));

        $password = $this->encoder->hashPassword($user, $input->getArgument('password'));
        $user->setPassword($password);

        $user->setRoles(['ROLE_ADMIN']);

        $user->setPrenom($input->getArgument('prenom'));

        $user->setNom($input->getArgument('nom'));

        $this->entityManagerInterface->persist($user);
        $this->entityManagerInterface->flush();

        $io->success('Nouveau compte Administrateur créé !');
        return Command::SUCCESS;
    }
}
