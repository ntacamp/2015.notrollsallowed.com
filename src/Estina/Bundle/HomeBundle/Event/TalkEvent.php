<?php

namespace Estina\Bundle\HomeBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * TalkEvent 
 */
class TalkEvent extends Event
{
    protected $talk;

    /**
     * __construct 
     * 
     * @param Talk $talk 
     */
    public function __construct($talk)
    {
        $this->talk = $talk;
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
}
