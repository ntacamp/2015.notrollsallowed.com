<?php

namespace Estina\Bundle\HomeBundle\EventListener;


use Estina\Bundle\HomeBundle\Event\TalkEvent;

/**
 * TalkListener 
 */
class TalkListener
{
    protected $mailer;

    public function __construct($mailer, $adminEmail)
    {
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
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
}
