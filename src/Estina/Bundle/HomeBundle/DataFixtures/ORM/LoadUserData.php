<?php
namespace Estina\Bundle\HomeBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Estina\Bundle\HomeBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $service = $this->container->get('home.user_service');

        $user = new User();
        $user->setName('admin');
        $user->setEmail('admin@notrollsallowed.com');
        $user->setPlainPassword('admin');
        $user->setRole('ROLE_ADMIN');
        $this->addReference('user.admin', $user);
        $service->createUser($user);

        $user = new User();
        $user->setName('user');
        $user->setEmail('user@notrollsallowed.com');
        $user->setPlainPassword('user');
        $this->addReference('user.user', $user);
        $service->createUser($user);
    }

    public function getOrder()
    {
        return 1;
    }
}
