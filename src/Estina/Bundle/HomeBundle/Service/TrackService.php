<?php

namespace Estina\Bundle\HomeBundle\Service;

use Doctrine\ORM\EntityManager;
use Estina\Bundle\HomeBundle\Entity\Track;

class TrackService
{
    /**
     * @var EntityManager
     */
    private $em;
    private $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository('EstinaHomeBundle:Talk');
    }

    /**
     * Check if track is full. 
     * 
     * @param Track $track 
     *
     * @return bool
     */
    public function isTrackFull(Track $track)
    {
        $talks = $this->repository->findActiveByTrack($track);

        return $track->getSize() <= count($talks);
    }
}
