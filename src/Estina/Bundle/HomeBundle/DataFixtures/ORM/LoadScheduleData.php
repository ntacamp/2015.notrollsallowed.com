<?php
namespace Estina\Bundle\HomeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Estina\Bundle\HomeBundle\Entity\Schedule;
use Estina\Bundle\HomeBundle\Entity\Talk;

class LoadScheduleData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Custom schedule entries
        $item = new Schedule();
        $item->setDay(1);
        $item->setTime(new \DateTime('10:00'));
        $item->setTrack($this->getReference('track.digital'));
        $item->setType(Schedule::TYPE_CUSTOM);
        $item->setTitle('Opening ceremony');
        $manager->persist($item);
        
        $item = new Schedule();
        $item->setDay(1);
        $item->setTime(new \DateTime('13:00'));
        $item->setType(Schedule::TYPE_CUSTOM);
        $item->setTitle('Lunch');
        $manager->persist($item);

        $item = new Schedule();
        $item->setDay(1);
        $item->setTime(new \DateTime('23:00'));
        $item->setTrack($this->getReference('track.digital'));
        $item->setType(Schedule::TYPE_CUSTOM);
        $item->setTitle('Concert');
        $manager->persist($item);

        $item = new Schedule();
        $item->setDay(1);
        $item->setTime(new \DateTime('14:00'));
        $item->setTrack($this->getReference('track.digital'));
        $item->setTalk($this->getReference('talk.1'));
        $manager->persist($item);

        $item = new Schedule();
        $item->setDay(1);
        $item->setTime(new \DateTime('11:30'));
        $item->setTrack($this->getReference('track.analog'));
        $item->setTalk($this->getReference('talk.2'));
        $manager->persist($item);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
