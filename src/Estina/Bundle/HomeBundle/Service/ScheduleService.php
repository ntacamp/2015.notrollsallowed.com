<?php

namespace Estina\Bundle\HomeBundle\Service;

use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\ORM\EntityManager;
use Estina\Bundle\HomeBundle\Entity\Schedule;

class ScheduleService
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
        $days = Schedule::days();

        $repo = $this->getRepository();
        foreach ($days as $day) {
            $times = $repo->findTimesByDay($day);
            $rows = [];
            foreach ($times as $time) {
                foreach ($tracks as $track) {
                    $scheduleEntries = $repo->findBy(
                        ['day' => $day, 'track' => $track, 'time' => $time]
                    );
                    $scheduleGlobalEntries = $repo->findBy(
                        ['day' => $day, 'track' => null, 'time' => $time]
                    );
                    if (!empty($scheduleEntries)) {
                        foreach ($scheduleEntries as $entry) {
                            // var_dump($entry);exit;
                            $rows[$time->format('H:i')][$track->getId()] = $this->scheduleToRow($entry);
                        }
                    }
                    if (!empty($scheduleGlobalEntries)) {
                        foreach ($scheduleGlobalEntries as $entry) {
                            $rows[$time->format('H:i') . ' !!'][$track->getId()] = $this->scheduleToRow($entry);
                        }
                    }

                    if (empty($scheduleEntries) && empty($scheduleGlobalEntries)) {
                        $rows[$time->format('H:i')][$track->getId()] = ['title' => ' - ', 'track' => null];
                    }
                    ksort($rows);      
                }
            }
            $timetable[] = [
                'title' => $day,
                'tracks' => $tracks,
                'rows' => $rows,
            ];
        }

        return $timetable;
    }

    private function scheduleToRow(Schedule $schedule)
    {
        return [
            'title' => $schedule->getTalk() ? $schedule->getTalk()->getTitle() : $schedule->getTitle(),
            'description' => $schedule->getTalk() ? $schedule->getTalk()->getDescription() : $schedule->getDescription(),
            'track' => $schedule->getTrack(),
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
