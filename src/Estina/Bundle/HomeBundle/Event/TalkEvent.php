<?php

namespace Estina\Bundle\HomeBundle\Event;

use Estina\Bundle\HomeBundle\TalkEvents;
use Symfony\Component\EventDispatcher\Event;

/**
 * TalkEvent
 */
class TalkEvent extends Event
{
    protected $talk;
    protected $type;

    /**
     * __construct
     *
     * @param Talk $talk
     */
    public function __construct($talk, $type = null)
    {
        if (null === $type) {
            $type = TalkEvents::CREATE;
        }

        $this->talk = $talk;
        $this->type = $type;
    }

    /**
     * getTalk
     *
     * @return Talk
     */
    public function getTalk()
    {
        return $this->talk;
    }

    /**
     * Returns a type of event.
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
