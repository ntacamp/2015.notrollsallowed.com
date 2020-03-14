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
        $talk->setLanguage('LT');
        $talk->setTitle('Kaip aš keliavau');
        $talk->setDescription('Papasakosiu apie savo keliones.');
        $talk->setType('presentation');
        $manager->persist($talk);
        $this->addReference('talk.1', $talk);

        $talk = new Talk();
        $talk->setUser($this->getReference('user.user'));
        $talk->setTrack($this->getReference('track.digital'));
        $talk->setLanguage('EN');
        $talk->setTitle('Esu keliautojas');
        $talk->setStatus($talk::STATUS_ACCEPTED);
        $talk->setDescription('Papasakosiu apie savo keliones irgi.');
        $talk->setType('workshop');
        $manager->persist($talk);
        $this->addReference('talk.2', $talk);

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
