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
            'status' => Talk::STATUS_ACCEPTED,
        ]);
    }

    public function findByTrackForPrinting(Track $track)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb
            ->select('t')
            ->from('Estina\Bundle\HomeBundle\Entity\Talk', 't')
            ->leftJoin('t.user', 'u')
            ->where('t.track = :track')
                ->setParameter('track', $track)
            ->andWhere('t.status = :status')
                ->setParameter('status', Talk::STATUS_ACCEPTED)
            ->orderBy('u.name', 'ASC');

        return $qb->getQuery()->getResult();
    }

}
