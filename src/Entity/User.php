<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\EntityListeners({"App\EventListener\Doctrine\UserListener"})
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}