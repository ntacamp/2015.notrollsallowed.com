<?php
namespace Estina\Bundle\HomeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Estina\Bundle\HomeBundle\Entity\Talk;

class LoadTalkData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $talk = new Talk();
        $talk->setUser($this->getReference('user.user'));
        $talk->setTrack($this->getReference('track.digital'));
        $talk->setTitle('Kaip aš keliavau');
        $talk->setDescription('Papasakosiu apie savo keliones.');
        $manager->persist($talk);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
