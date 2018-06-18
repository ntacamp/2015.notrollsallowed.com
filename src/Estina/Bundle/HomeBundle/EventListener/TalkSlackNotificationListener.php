<?php

namespace Estina\Bundle\HomeBundle\EventListener;

use CL\Slack\Payload\ChatPostMessagePayload;
use CL\Slack\Transport\ApiClientInterface;
use Estina\Bundle\HomeBundle\Event\TalkEvent;
use Symfony\Component\Routing\RouterInterface;

/**
 * TalkListener 
 */
class TalkSlackNotificationListener
{
    /** @var ApiClient */
    protected $api;

    /** @var RouterInterface */
    protected $router;

    public function __construct(ApiClientInterface $api, RouterInterface $router)
    {
        $this->api = $api;
        $this->router = $router;
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

    private function notify(TalkEvent $event)
    {
        $talk = $event->getTalk();

        $payload  = new ChatPostMessagePayload();
        $payload->setChannel('#pranesimai');
        $payload->setUsername('Registratorius');
        $payload->setIconEmoji('space_invader');
        
        $url = $this->router->generate('talk', ['id' => $talk->getId()], true);
        $message = sprintf('[%s] <%s|%s> [%s] %s',
            $event->getType(), $url, $talk, $talk->getLanguage(), $talk->getUser());
        $message .= "\n";
        $message .= $talk->getDescription();

        $payload->setText($message); // also supports Slack formatting

        $response = $this->api->send($payload);
        if (!$response->isOk()) {
            // log error? do smth?
        }
    }
}
