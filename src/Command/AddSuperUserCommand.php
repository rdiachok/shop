<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddSuperUserCommand extends Command
{
    protected static $defaultName = 'app:add-super-user';
    protected static $defaultDescription = 'add new user with role - superAdmin';
    private $passwordEncoder;
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    public function __construct(UserPasswordEncoderInterface $passwordEncoder,
        private EntityManagerInterface $entityManager,
        private UsersRepository $users
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('firstName', InputArgument::REQUIRED, 'The user name of the user.')
            ->addArgument('lastName', InputArgument::REQUIRED, 'The last name of the user.')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $firstName = $input->getArgument('firstName');
        $lastName = $input->getArgument('lastName');
        $email = $input->getArgument('email');

        // make sure to validate the user data is correct
        $this->validateUserData($email);

        // create the user
        $user = new Users();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setRoles([self::ROLE_SUPER_ADMIN]);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            '1234'
            )); 

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('First Name: ' . $input->getArgument('firstName'));
        $output->writeln('Last Name: ' . $input->getArgument('lastName'));
        $output->writeln('Email: ' . $input->getArgument('email'));

        $io->success('You are added new Super user');

        return 0;
    }

    private function validateUserData($email): void
    {
        // check if a user with the same email already exists.
        $existingEmail = $this->users->findOneBy(['email' => $email]);

        if (null !== $existingEmail) {
            throw new RuntimeException(sprintf('There is already a user registered with the "%s" email.', $email));
        }
    }
}
