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
            'talk_status' => new \Twig_Filter_Method($this, 'getTalkStatus'),
            'talk_status_color' => new \Twig_Filter_Method($this, 'getTalkStatusColor'),
        );
    }

    /**
     * Generate talk status message
     */
    public function getTalkStatus(Talk $talk)
    {
        $map = [
            Talk::STATUS_NEW => 'Naujas',
            Talk::STATUS_ACCEPTED => 'Patvirtintas',
            Talk::STATUS_REJECTED => 'Atmestas',
            Talk::STATUS_CANCELLED => 'Nedalyvausiu',
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
            Talk::STATUS_CANCELLED => 'warning',
        ];

        return $this->mapValue($talk->getStatus(), $map);;
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
