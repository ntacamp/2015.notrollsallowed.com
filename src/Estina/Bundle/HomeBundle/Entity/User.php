<?php

namespace Estina\Bundle\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Estina\Bundle\HomeBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("email")
 */
class User implements UserInterface, \Serializable
{
    protected $availableLocales = ['en', 'lt'];
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=25, nullable=true)
     * @Assert\Length(max="25")
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     * @Assert\NotBlank()
     * @Assert\Length(max="32")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=64, unique=true)
     * @Assert\Email()
     * @Assert\NotBlank()
     * @Assert\Length(max="64")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     * @Assert\Length(max="32")
     */
    private $phone;

    /**
     * @var
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @Assert\Length(min="4", max="24")
     */
    private $plainPassword;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime")
     */
    private $createdOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_reset_time", type="datetime", nullable=true)
     */
    private $lastResetTime;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=64)
     */
    private $role = 'ROLE_USER';

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=2)
     */
    private $locale = 'en';

    /**
     * @var boolean
     *
     * @ORM\Column(name="consent", type="boolean")
     */
    private $consent = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="volunteer", type="boolean")
     */
    private $volunteer = 0;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param mixed $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return \DateTime
     */
    public function getLastResetTime()
    {
        return $this->lastResetTime;
    }

    /**
     * @param \DateTime $lastResetTime
     */
    public function setLastResetTime(\DateTime $lastResetTime)
    {
        $this->lastResetTime = $lastResetTime;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // NOT REQUIRED BECAUSE OF BCRYPT
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     * @return User
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set active
     *
     * @param bool $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return array($this->role);
    }

    /**
     *
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param $password
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            ) = unserialize($serialized);
    }

    /**
     * @ORM\PreFlush
     */
    public function preFlush()
    {
        if ($this->id) {
            $this->updatedAt = new \DateTime;
        } else {
            $this->createdOn = new \DateTime;
        }
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return empty($this->locale) ? 'en': $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        if (!in_array($locale, $this->availableLocales)) {
            $locale = 'en';
        }
        $this->locale = $locale;
    }

    /**
     * @return boolean
     */
    public function getConsent()
    {
        return $this->consent;
    }

    /**
     * @param boolean $consent
     *
     * @return self
     */
    public function setConsent($consent)
    {
        $this->consent = $consent;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getVolunteer()
    {
        return $this->volunteer;
    }

    /**
     * @param boolean $volunteer
     *
     * @return self
     */
    public function setVolunteer($volunteer)
    {
        $this->volunteer = $volunteer;

        return $this;
    }
}
