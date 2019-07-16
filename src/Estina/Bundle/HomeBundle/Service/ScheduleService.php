<?php

namespace Estina\Bundle\HomeBundle\Service;

use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\ORM\EntityManager;
use Estina\Bundle\HomeBundle\Entity\Schedule;
use Estina\Bundle\HomeBundle\Entity\Track;

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

    public function generate($day = null, Track $trackArg = null)
    {
        $tracks = $this->getTrackRepository()->findTracksByType(Track::TYPE_TALK);
        $timetable = [];
        $days = Schedule::days();
        if ($day) {
            $days = [$day];
        }
        
        $repo = $this->getRepository();
        foreach ($days as $day) {
            if (null !== $trackArg) {
                $times = $repo->findTimesByDayAndTrack($day, $trackArg->getId());
            } else {
                $times = $repo->findTimesByDay($day);
            }

            $rows = [];
            foreach ($times as $time) {
                /** @var Track $track */
                foreach ($tracks as $track) {
                    if ($trackArg !== null && $trackArg->getId() != $track->getId()) {
                        continue;
                    }
                    $scheduleEntries = $repo->findBy(
                        ['day' => $day, 'track' => $track, 'time' => $time]
                    );
                    $scheduleGlobalEntries = $repo->findBy(
                        ['day' => $day, 'track' => null, 'time' => $time]
                    );
                    if (!empty($scheduleEntries)) {
                        foreach ($scheduleEntries as $entry) {
                            $rows[$time->format('H:i')][$track->getId()] = $this->scheduleToRow($entry);
                        }
                    }
                    if (!empty($scheduleGlobalEntries)) {
                        foreach ($scheduleGlobalEntries as $entry) {
                            $rows[$time->format('H:i') . ' !!'][$track->getId()] = $this->scheduleToRow($entry);
                        }
                    }

                    if (empty($scheduleEntries) && empty($scheduleGlobalEntries)) {
                        $rows[$time->format('H:i')][$track->getId()] = ['track' => null];
                    }
                    ksort($rows);                     
                }
            }
            $timetable[$day] = [
                'title' => $day,
                'tracks' => $tracks,
                'rows' => $rows,
            ];
        }

        return $timetable;
    }

    public function getAvailableSlots(Track $track)
    {
        $slotsInUse = $this->generate(null, $track);
        $days = Schedule::days();

        $slots = [];
        foreach ($days as $day) {
            $begin = new DateTime('10:00');
            $end = new DateTime('04:00');
            $end->add(new DateInterval('P1D'));
            $interval = new DateInterval('PT30M');
            $range = new DatePeriod($begin, $interval, $end);
            foreach ($range as $date) {
                $time = $date->format('H:i');

                if (isset($slotsInUse[$day]['rows'][$time]) && array_key_exists($track->getId(), $slotsInUse[$day]['rows'][$time])) {
                    continue;
                }
                if (array_key_exists($time . '!!', $slotsInUse[$day]['rows'])) {
                    continue;
                }
                $slots[$day][] = $time;
            }
        }

        return $slots;
    }

    private function scheduleToRow(Schedule $schedule)
    {
        return [
            'title' => $schedule->getTalk() ? $schedule->getTalk()->getTitle() : $schedule->getTitle(),
            'description' => $schedule->getTalk() ? $schedule->getTalk()->getDescription() : $schedule->getDescription(),
            'track' => $schedule->getTrack(),
            'author' => $schedule->getTalk() ? $schedule->getTalk()->getUser()->getName() : '',
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
