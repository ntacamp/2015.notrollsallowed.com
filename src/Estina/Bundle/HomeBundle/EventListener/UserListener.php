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

    protected $translator;

    /**
     * @param $mailer
     * @param $templating
     * @param $translator
     */
    public function __construct($mailer, $templating, $translator)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->translator = $translator;
    }

    /**
     * @param PasswordResetEvent $event
     */
    public function onPasswordReset(PasswordResetEvent $event)
    {
        $user = $event->getUser();
        $this->translator->setLocale($user->getLocale());

        $template = $this->templating->render('email_password.html.twig', [
            'email' => $user->getEmail(),
            'password' => $user->getPlainPassword()
        ]);

        $message = \Swift_Message::newInstance()
            ->setSubject($this->translator->trans('email.password_reset.subject'))
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
        $this->translator->setLocale($user->getLocale());

        $template = $this->templating->render('email_register.html.twig', [
            'email' => $user->getEmail(),
            'password' => $user->getPlainPassword()
        ]);

        $message = \Swift_Message::newInstance()
            ->setSubject($this->translator->trans('email.registration.subject'))
            ->setFrom('hi@notrollsallowed.com', 'No Trolls Allowed')
            ->setTo($user->getEmail())
            ->setBody($template, 'text/html')
        ;

        $this->mailer->send($message);
    }

}
