<?php

namespace Estina\Bundle\HomeBundle\Entity;

/**
 * TalkRepository
 */
class TalkRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByUser(User $user)
    {
        return $this->findBy(['user' => $user]);
    }

    public function findActiveByTrack(Track $track)
    {
        return $this->findBy([
            'track'  => $track,
            'active' => 1,
        ]);
    }
}
