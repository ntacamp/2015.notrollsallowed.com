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

    protected $templating;

    /**
     * @param $mailer
     * @param $templating
     */
    public function __construct($mailer, $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param PasswordResetEvent $event
     */
    public function onPasswordReset(PasswordResetEvent $event)
    {
        $user = $event->getUser();

        $template = $this->templating->render('email_password.html.twig', [
            'email' => $user->getEmail(),
            'password' => $user->getPlainPassword()
        ]);

        $message = \Swift_Message::newInstance()
            ->setSubject('Slaptažodžio priminimas')
            ->setFrom('hi@notrollsallowed.com')
            ->setTo($user->getEmail())
            ->setBody($template)
        ;

        $this->mailer->send($message);
    }

    /**
     * @param RegistrationEvent $event
     */
    public function onRegistrationFinished(RegistrationEvent $event)
    {
        $user = $event->getUser();

        $template = $this->templating->render('email_register.html.twig', [
            'email' => $user->getEmail(),
            'password' => $user->getPlainPassword()
        ]);

        $message = \Swift_Message::newInstance()
            ->setSubject('NoTrollsAllowed registracija')
            ->setFrom('hi@notrollsallowed.com')
            ->setTo($user->getEmail())
            ->setBody($template)
        ;

        $this->mailer->send($message);
    }

}
