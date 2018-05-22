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
            ->setSubject('Password reset')
            ->setFrom('hi@notrollsallowed.com', 'No Trolls Allowed')
            ->setTo($user->getEmail())
            ->setBody($template, 'text/html')
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
            ->setSubject('Congratulations! You just registered to No Trolls Allowed 2018')
            ->setFrom('hi@notrollsallowed.com', 'No Trolls Allowed')
            ->setTo($user->getEmail())
            ->setBody($template, 'text/html')
        ;

        $this->mailer->send($message);
    }

}
