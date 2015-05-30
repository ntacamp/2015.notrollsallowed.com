<?php

namespace Estina\Bundle\HomeBundle\Service;

use Doctrine\ORM\EntityManager;
use Estina\Bundle\HomeBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserService
{

    /**
     * @var UserPasswordEncoder
     */
    private $encoder;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param UserPasswordEncoder $encoder
     * @param EntityManager $em
     */
    function __construct(UserPasswordEncoder $encoder, EntityManager $em)
    {
        $this->encoder = $encoder;
        $this->em = $em;
    }

    /**
     * @param User $entity
     * @return User
     */
    public function encodePassword(User $entity)
    {

        if (null == $entity->getPlainPassword()) {
            $newPassword = $this->randomPassword();
            $entity->setPlainPassword($newPassword);
        }

        $encodedPassword = $this->encoder->encodePassword($entity, $entity->getPlainPassword());
        $entity->setPassword($encodedPassword);
    }

    /**
     * @param User $entity
     * @return User
     */
    public function createUser(User $entity)
    {
        $this->encodePassword($entity);
        $this->saveUser($entity);

        return $entity;
    }

    /**
     * @param User $entity
     */
    public function saveUser(User $entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @param $email
     * @return bool
     */
    public function resetPassword($email)
    {
        $user = $this->em->getRepository('EstinaHomeBundle:User')->findOneBy(['email' => $email]);
        if ($user) {

            $now = new \DateTime();
            $limit = $now;

            if ($user->getLastResetTime()) {
                $limit = $user->getLastResetTime()->add(new \DateInterval('P0DT0H30M0S'));
            }

            if ($now >= $limit) {
                $newPassword = $this->randomPassword();
                $user->setPlainPassword($newPassword);
                $user->setLastResetTime($now);
                $this->encodePassword($user);
                $this->saveUser($user);

                return $user;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    private function randomPassword()
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass); //turn the array into a string
    }
}
