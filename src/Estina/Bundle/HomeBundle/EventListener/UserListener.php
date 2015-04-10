<?php

namespace Estina\Bundle\HomeBundle\EventListener;

use Estina\Bundle\HomeBundle\Event\PasswordResetEvent;
use Estina\Bundle\HomeBundle\Event\RegistrationEvent;

/**
 * UserListener
 */
class UserListener
{
    /**
     * @var
     */
    protected $mailer;

    /**
     * @param $mailer
     */
    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param PasswordResetEvent $event
     */
    public function onPasswordReset(PasswordResetEvent $event)
    {
        $user = $event->getUser();

        $subject = 'Slaptažodžio priminimas: ' . $user->getName();
        $body = <<<EOT
====================
Prisijungimas vardas: {$user->getEmail()}
Slaptažodis: {$user->getPlainPassword()}
====================
EOT;

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom('no-reply@notrollsallowed.com')
            ->setTo($user->getEmail())
            ->setBody($body)
        ;

        $this->mailer->send($message);
    }

    /**
     * @param RegistrationEvent $event
     */
    public function onRegistrationFinished(RegistrationEvent $event)
    {
        //TODO IMPLEMENT MAIL SENDING
    }

}
