<?php

namespace Estina\Bundle\HomeBundle\Service;

use Doctrine\ORM\EntityManager;
use DateTime;
use DateInterval;
use DatePeriod;

class ScheduleTimetableService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function generate()
    {
        $tracks = $this->getTrackRepository()->findTracks();
        $timetable = [];
        $begin = new DateTime('2017-07-29 10:00');
        $end = new DateTime('2017-07-29 23:59');
        $interval = new DateInterval('PT30M');
        $daterange = new DatePeriod($begin, $interval, $end);

        $i = 1;
        foreach ($daterange as $date) {
            echo $i++ . ' ' . $date->format("Y-m-d H:i") . "<br>";
        }
        exit;
        // foreach ($tracks as $track) {
            $timatable[] = [
                'time' => '',
                'talks' => [], //$this->getTalkRepository()->findActiveByTrack($track)
            ];
        // }
        return [
        ];
    }

    private function getRepository()
    {
        return $this->em->getRepository('EstinaHomeBundle:Schedule');
    }

    private function getTrackRepository()
    {
        return $this->em->getRepository('EstinaHomeBundle:Track');
    }
    private function getTalkRepository()
    {
        return $this->em->getRepository('EstinaHomeBundle:Talk');
    }
}
