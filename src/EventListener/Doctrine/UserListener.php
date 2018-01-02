<?php

namespace App\EventListener\Doctrine;

use App\Model\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

/**
 * Class UserListener
 *
 * @package App\EventListener\Doctrine
 */
class UserListener
{
    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * UserListener constructor.
     * @param UserPasswordEncoder $passwordEncoder
     */
    public function __construct(UserPasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User $user
     * @param LifecycleEventArgs $event
     */
    public function prePersist(User $user, LifecycleEventArgs $event)
    {
        $this->encodePassword($user);
    }

    /**
     * @param User $user
     */
    public function preUpdate(User $user)
    {
        $this->encodePassword($user);
    }

    /**
     * @param User $user
     */
    private function encodePassword(User $user)
    {
        if ( ! $user->getPlainPassword()) {
            return;
        }

        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $user->getPlainPassword())
        );
    }
}
