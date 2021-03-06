<?php

namespace Estina\Bundle\HomeBundle\Twig;

use Estina\Bundle\HomeBundle\Entity\Talk;

/**
 * TalkStatus
 */
class TalkExtension extends \Twig_Extension
{
    /**
     * Return registered filters
     *
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('talk_status', [$this, 'getTalkStatus']),
            new \Twig_SimpleFilter('talk_emoji', [$this, 'getTalkEmoji']),
            new \Twig_SimpleFilter('talk_status_color', [$this, 'getTalkStatusColor']),
        );
    }

    /**
     * Generate talk status message
     */
    public function getTalkStatus(Talk $talk)
    {
        $map = [
            Talk::STATUS_NEW => 'New',
            Talk::STATUS_ACCEPTED => 'Confirmed',
            Talk::STATUS_REJECTED => 'Rejected',
            Talk::STATUS_CANCELLED => 'Canceled',
            Talk::STATUS_CHANGES_REQUESTED => 'Requested for Changes',
        ];

        return $this->mapValue($talk->getStatus(), $map);;
    }


    /**
     * Get talk status state for badge color. 
     * Uses bootstrap alert/badge names.
     */
    public function getTalkStatusColor(Talk $talk)
    {
        $map = [
            Talk::STATUS_NEW => 'info',
            Talk::STATUS_ACCEPTED => 'success',
            Talk::STATUS_REJECTED => 'danger',
            Talk::STATUS_CANCELLED => 'danger',
            Talk::STATUS_CHANGES_REQUESTED => 'warning',
        ];

        return $this->mapValue($talk->getStatus(), $map);;
    }


    public function getTalkEmoji()
    {
        $response = file_get_contents('https://ranmoji.herokuapp.com/emojis/api/v.1.0/');
        $data = json_decode($response, true);
        return $data['emoji'];
    }

    private function mapValue($status, $map)
    {
        if (!isset($map[$status])) {
            throw new \RuntimeException('Unexpected talk status');
        }

        return $map[$status];
    }

    /**
     * Name
     *
     * @return string
     */
    public function getName()
    {
        return 'talk';
    }

}
