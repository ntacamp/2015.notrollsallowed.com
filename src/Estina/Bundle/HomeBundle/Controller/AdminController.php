<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Estina\Bundle\HomeBundle\Entity\Talk;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * AdminController
 */
class AdminController extends Controller
{
    /**
     * @Template()
     */
    public function statsAction()
    {
        $repo = $this->getDoctrine()->getRepository('Estina\Bundle\HomeBundle\Entity\Track');
        $tracks = $repo->findTracks();

        $data = $this->aggregate($tracks);

        return [
            'total' => $data['total'],
            'tracks' => $data['tracks'],
        ];
    }

    private function aggregate(array $tracks)
    {
        $data = [
            'total' => [
                Talk::STATUS_NEW        => 0,
                Talk::STATUS_ACCEPTED   => 0,
                Talk::STATUS_REJECTED   => 0,
                Talk::STATUS_CANCELLED  => 0,
                'total'                 => 0,
            ],
            'tracks' => []
        ];

        foreach ($tracks as $track) {
            $id = $track->getId();
            if (!isset($data['tracks'][$id])) {
                $data['tracks'][$id] = $this->getTrackTemplate($track);
            }
            foreach ($track->getTalks() as $talk) {
                $status = $talk->getStatus();

                $data['total'][$status]++;
                $data['total']['total']++;
                $data['tracks'][$id][$status]++;
                $data['tracks'][$id]['total']++;
            }
        }

        return $data;
    }

    private function getTrackTemplate($track)
    {
        return [
            'track'                 => $track,
            Talk::STATUS_NEW        => 0,
            Talk::STATUS_ACCEPTED   => 0,
            Talk::STATUS_REJECTED   => 0,
            Talk::STATUS_CANCELLED  => 0,
            'total'                 => 0,
        ];
    }

}
