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
    protected $translator;

    public function __construct($mailer, $adminEmail, $templating, $translator)
    {
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
        $this->templating = $templating;
        $this->translator = $translator;
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
===============================================================================
PRANEŠĖJAS
===============================================================================
{$talk->getUser()}
{$talk->getUser()->getEmail()}
{$talk->getUser()->getPhone()}

===============================================================================
PRANEŠIMAS
===============================================================================
TITLE:        {$talk->getTitle()} [{$talk->getLanguage()}]
TYPE:         {$talk->getType()}
REQUIREMENTS: {$talk->getRequirements()}
COMMENTS:     {$talk->getComments()}
QUESTION #1:  {$talk->getQuestion1()}

{$talk->getDescription()}
EOT;

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($talk->getUser()->getEmail())
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
        $this->translator->setLocale($talk->getUser()->getLocale());
        $subject = $this->translator->trans('email.confirmation.subject');

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
