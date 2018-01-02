<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class AppUserCreateCommand
 *
 * @package App\Command
 */
class AppUserCreateCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:user:create';

    protected function configure()
    {
        $this
            ->setDescription('New user create.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask('Email');
        $password = $io->askHidden('Password');
        $roles = $io->choice('Role', array('ROLE_USER', 'ROLE_ADMIN'), 'ROLE_USER');

        $class = $this->getContainer()->getParameter('user_class');

        $user = new $class();
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setRoles((array) $roles);

        /** @var EntityManagerInterface $em */
        $em = $this
            ->getContainer()
            ->get('doctrine.orm.entity_manager');

        $em->persist($user);
        $em->flush();

        $io->success(sprintf('User(#%d) created!', $user->getId()));
    }
}
