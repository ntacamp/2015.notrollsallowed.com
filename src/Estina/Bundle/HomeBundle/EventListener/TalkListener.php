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
     * @param GetResponseForExceptionEvent $event 
     */
    public function onCreate(TalkEvent $event)
    {
        $talk = $event->getTalk();

        if (null === $this->adminEmail) {
            return;
        }

        $subject = 'Registracija: ' . $talk->getSpeaker();
        $body = <<<EOT
====================
PRANEŠĖJAS
====================
{$talk->getSpeaker()}
{$talk->getEmail()}
{$talk->getPhone()}

====================
PRANEŠIMAS
====================
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
