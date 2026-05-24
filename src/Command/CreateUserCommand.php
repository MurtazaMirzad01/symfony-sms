<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Add a short description for your command',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $hasher
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
       $user= new User();
       $user->setEmail(
           'admin@test.com'
       );
       $user->setRoles(['ROLE_ADMIN']);
       $user->setPassword(
           $this->hasher->hashPassword(
               $user,
               'admin@123'
           )
       );

       $this->em->persist($user);
       $this->em->flush();
       $output->writeln(
           '<info> User created!</info>'
       );

        return Command::SUCCESS;
    }
}
