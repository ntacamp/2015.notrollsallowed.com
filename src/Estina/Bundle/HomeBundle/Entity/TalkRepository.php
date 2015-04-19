<?php

namespace Estina\Bundle\HomeBundle\Entity;

/**
 * TalkRepository
 */
class TalkRepository extends \Doctrine\ORM\EntityRepository
{
    public function findTalksByUser(User $user)
    {
        return $this->findBy(['user' => $user]);
    }
}
