<?php

namespace Estina\Bundle\HomeBundle\EventListener;

use CL\Slack\Payload\ChatPostMessagePayload;
use CL\Slack\Transport\ApiClientInterface;
use Estina\Bundle\HomeBundle\Event\TalkEvent;
use Estina\Bundle\HomeBundle\TalkEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * TalkListener 
 */
class TalkSlackNotificationListener
{
    /** @var ApiClient */
    protected $api;

    /** @var RouterInterface */
    protected $router;

    protected $tokenStorage;

    public function __construct(
        ApiClientInterface $api,
        RouterInterface $router,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->api = $api;
        $this->router = $router;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Item created 
     * 
     * @param TalkEvent $event 
     */
    public function onCreate(TalkEvent $event)
    {
        $this->notify($event);
    }

    public function onUpdate(TalkEvent $event)
    {
        $this->notify($event);
    }

    private function getUserName()
    {
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return null;
        }
        $user = $token->getUser();
        if (!$user) {
            return null;
        }

        return $user->getName();
    }

    private function notify(TalkEvent $event)
    {
        $talk = $event->getTalk();

        $payload  = new ChatPostMessagePayload();
        $payload->setChannel('#pranesimai');
        $payload->setUsername('Registratorius');
        $payload->setIconEmoji('space_invader');
        
        $prefix = ":new:";
        if ($event->getType() == TalkEvents::UPDATE) {
            $userName = $this->getUserName();
            $prefix = sprintf('*UPDATED*%s:', ($userName) ? sprintf(' by *%s*', $userName) : '');
        }
        $url = $this->router->generate('talk', ['id' => $talk->getId()], true);
        $message = sprintf('%s <%s|%s> [%s] %s',
            $prefix, $url, $talk, $talk->getLanguage(), $talk->getUser());
        $message .= "\n";
        $message .= '> ' . str_replace("\n", "\n> ", $talk->getDescription());

        $payload->setText($message); // also supports Slack formatting
        $response = $this->api->send($payload);
    }
}
