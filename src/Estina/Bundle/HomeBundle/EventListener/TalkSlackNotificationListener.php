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
        $talk = $event->getTalk();

        $payload  = new ChatPostMessagePayload();
        $payload->setChannel('#pranesimai');
        $payload->setUsername('Registratorius'); // can be anything you want
        $payload->setIconEmoji('space_invader'); // check out emoji.list-payload for a list of available emojis
        
        $url = $this->router->generate('talk', ['id' => $talk->getId()], true);
        $message = sprintf('[%s]: <%s|%s> %s', $talk->getTrack(), $url, $talk, $talk->getUser());
        $message .= "\n";
        $message .= $talk->getDescription();

        $payload->setText($message); // also supports Slack formatting

        $response = $this->api->send($payload);
        if (!$response->isOk()) {
            // log error? do smth?
        }
    }
}
