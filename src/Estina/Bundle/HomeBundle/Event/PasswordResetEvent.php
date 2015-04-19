<?php

namespace Estina\Bundle\HomeBundle\Event;

use Estina\Bundle\HomeBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * PasswordResetEvent
 */
class PasswordResetEvent extends Event
{
    protected $user;

    /**
     * __construct
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * getUser
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
