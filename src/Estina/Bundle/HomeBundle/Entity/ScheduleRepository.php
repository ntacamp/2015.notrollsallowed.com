<?php

namespace Estina\Bundle\HomeBundle\Entity;

/**
 * ScheduleRepository
 */
class ScheduleRepository extends \Doctrine\ORM\EntityRepository
{
    public function findTimesByDay($day)
    {
        $data = $this->findBy(['day' => $day]);
        $return = [];
        foreach ($data as $item) {
            if (!in_array($item->getTime(), $return)) {
                $return[] = $item->getTime();
            }
        }
        return $return;
    }
}
