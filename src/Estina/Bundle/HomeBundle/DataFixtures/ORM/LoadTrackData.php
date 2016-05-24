<?php
namespace Estina\Bundle\HomeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Estina\Bundle\HomeBundle\Entity\Track;

class LoadTrackData extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $track = new Track();
        $track->setTitle('Digital');
        $track->setDescription('Gyvenimas virtualioje erdvėje, programavimas, saugumas ir kitos, su informacinėmis technologijomis susijusios temos.');
        $track->setSize(30);
        $track->setPosition(1);
        $track->setType($track::TYPE_TALK);
        $this->addReference('track.digital', $track);
        $manager->persist($track);

        $track = new Track();
        $track->setTitle('Analog');
        $track->setDescription('Hobiai, projektai, ir kiti apčiuopiami dalykai, iš to kito, analoginio gyvenimo (kai kas jį vadina "tikru").');
        $track->setSize(30);
        $track->setPosition(2);
        $track->setType($track::TYPE_TALK);
        $manager->persist($track);

        $track = new Track();
        $track->setTitle('Mental');
        $track->setDescription('Telepatija, telekinezė, levitacija, minčių skaitymas, psichologija, lifehack\'ai ir kitos su minties galia susijusios temos.');
        $track->setSize(30);
        $track->setPosition(3);
        $track->setType($track::TYPE_TALK);
        $manager->persist($track);

        $track = new Track();
        $track->setTitle('/dev/random');
        $track->setDescription('Visa kita, kas netilpo į kitas scenas.');
        $track->setSize(30);
        $track->setPosition(4);
        $track->setType($track::TYPE_TALK);
        $manager->persist($track);

        $track = new Track();
        $track->setTitle('Dirbtuvės');
        $track->setDescription('Užsiėmimai renginio metu, nebūtinai vyksiantys konkrečioje scenoje. Jie gali vykti tam tikru metu arba tęstis visą renginį. Jei norite kažką pademonstruoti renginio metu - registruokite čia. Dirbtuves galite registruoti, kaip papildomą pranešimą.');
        $track->setSize(20);
        $track->setPosition(5);
        $track->setType($track::TYPE_WORKSHOP);
        $manager->persist($track);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
