<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class AppUserChangePasswordCommand
 *
 * @package App\Command
 */
class AppUserChangePasswordCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'app:user:change-password';

    protected function configure()
    {
        $this
            ->setDescription('User password change.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask('Email');
        $password = $io->askHidden('Password');

        $class = $this->getContainer()->getParameter('user_class');

        /** @var EntityManagerInterface $em */
        $em = $this
            ->getContainer()
            ->get('doctrine.orm.entity_manager');

        $user = $em->getRepository($class)->findOneBy(['email' => $email]);
        $user->setPlainPassword($password);

        $em->persist($user);
        $em->flush();

        $io->success('The password was successfully changed.');
    }
}
