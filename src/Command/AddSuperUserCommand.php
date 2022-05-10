<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use App\Utils\Validator;

class AddSuperUserCommand extends Command
{
    protected static $defaultName = 'app:add-super-user';
    protected static $defaultDescription = 'add new user with role - superAdmin';
    const SUPER_ADMIN = 'superAdmin';

    public function __construct(
        //private EntityManagerInterface $entityManager,
        //private Validator $validator,
        //private UsersRepository $users
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('firstName', InputArgument::REQUIRED, 'The user name of the user.')
            ->addArgument('lastName', InputArgument::REQUIRED, 'The last name of the user.')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $firstName = $input->getArgument('firstName');
        $lastName = $input->getArgument('lastName');
        $email = $input->getArgument('email');

        // make sure to validate the user data is correct
        $this->validateUserData($firstName, $lastName, $email);

        // create the user
        $user = new Users();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setRole(self::SUPER_ADMIN);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('First Name: ' . $input->getArgument('firstName'));
        $output->writeln('Last Name: ' . $input->getArgument('lastName'));
        $output->writeln('Email: ' . $input->getArgument('email'));

        $io->success('You are added new Super user');

        return 0;
    }

    private function validateUserData($firstName, $lastName, $email): void
    {
        // validate password and email if is not this input means interactive.
        $this->validator->validateFirstName($firstName);
        $this->validator->validateLastName($lastName);
        $this->validator->validateEmail($email);

        // check if a user with the same email already exists.
        $existingEmail = $this->users->findOneBy(['email' => $email]);

        if (null !== $existingEmail) {
            throw new RuntimeException(sprintf('There is already a user registered with the "%s" email.', $email));
        }
    }
}
