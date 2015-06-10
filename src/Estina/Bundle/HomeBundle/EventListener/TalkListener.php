<?php

namespace Estina\Bundle\HomeBundle\EventListener;

use Estina\Bundle\HomeBundle\Event\TalkEvent;

/**
 * TalkListener 
 */
class TalkListener
{
    protected $mailer;
    protected $adminEmail;
    protected $templating;

    public function __construct($mailer, $adminEmail, $templating)
    {
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
        $this->templating = $templating;
    }

    /**
     * Item created 
     * 
     * @param TalkEvent $event 
     */
    public function onCreate(TalkEvent $event)
    {
        $talk = $event->getTalk();

        if (null === $this->adminEmail) {
            return;
        }

        $subject = sprintf('Registracija: %s [%s]', $talk, $talk->getUser());
        $body = <<<EOT
====================
PRANEŠĖJAS
====================
{$talk->getUser()}
{$talk->getUser()->getEmail()}
{$talk->getUser()->getPhone()}

====================
PRANEŠIMAS
====================
{$talk->getTrack()}
{$talk->getTitle()}
{$talk->getDescription()}
EOT;

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->adminEmail)
            ->setTo($this->adminEmail)
            ->setBody($body)
        ;

        $this->mailer->send($message);
    }

    /**
     * @param TalkEvent $event
     */
    public function onConfirm(TalkEvent $event)
    {
        $talk = $event->getTalk();

        if (null === $this->adminEmail) {
            return;
        }

        $subject = 'NTA2015 pranešimo patvirtinimas';

        $template = $this->templating->render('email_confirmation.html.twig');

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->adminEmail)
            ->setTo($talk->getUser()->getEmail())
            ->setBody($template, 'text/html')
        ;

        $this->mailer->send($message);
    }

}
