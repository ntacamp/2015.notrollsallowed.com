<?php

namespace Estina\Bundle\HomeBundle\Event;

use Estina\Bundle\HomeBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * RegistrationEvent
 */
class RegistrationEvent extends Event
{
    const NAME = 'registration_event';

    /**
     * @var User
     */
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
