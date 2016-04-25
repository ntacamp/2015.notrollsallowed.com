<?php

namespace Estina\Bundle\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Estina\Bundle\HomeBundle\Validator\Constraints as EstinaAssert;

/**
 * Talk
 *
 * @ORM\Table(name="talk")
 * @ORM\Entity(repositoryClass="Estina\Bundle\HomeBundle\Entity\TalkRepository")
 */
class Talk
{
    /** New talk submitted */
    const STATUS_NEW = 'new';
    
    /** Talk has been accepted by admins */
    const STATUS_ACCEPTED = 'accepted';
    
    /** Talk has been rejected by admins */
    const STATUS_REJECTED = 'rejected';

    /** Speaker changed his mind */
    const STATUS_CANCELLED = 'cancelled';
    
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
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
    private $updatedAt = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="accepted_at", type="datetime", nullable=true)
     */
    private $acceptedAt = null;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="string", length=20)
     */
    private $status = self::STATUS_NEW;

    /**
     * @var boolean
     *
     * @ORM\Column(name="language", type="string", length=20)
     */
    private $language;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user;

    /**
     * @Assert\NotBlank()
     * @EstinaAssert\TrackNotFull()
     * @ORM\ManyToOne(targetEntity="Track", inversedBy="talks")
     * @ORM\JoinColumn(name="track_id", referencedColumnName="id")
     **/
    private $track;

    /**
     * If speaker/organizer is not the same unit as author, this field can be
     * used to override author.
     *
     * @ORM\Column(name="organizer", type="string", length=64, nullable=true)
     * @Assert\Length(max="64")
     **/
    private $organizer;

    public function __construct()
    {
        $this->createdOn = $this->updatedAt = new \DateTime;
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return Talk
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Talk
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdOn
     *
     * @param \DateTime $createdOn
     *
     * @return Talk
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
     *
     * @return Talk
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
     * Set user
     *
     * @param User $user
     *
     * @return Talk
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set track
     *
     * @param Track $track
     *
     * @return Talk
     */
    public function setTrack(Track $track)
    {
        $this->track = $track;

        return $this;
    }

    /**
     * getTrack
     *
     * @return Track
     */
    public function getTrack()
    {
        return $this->track;
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Talk
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set acceptedAt
     *
     * @param \DateTime $acceptedAt
     *
     * @return Talk
     */
    public function setAcceptedAt($acceptedAt)
    {
        $this->acceptedAt = $acceptedAt;

        return $this;
    }

    /**
     * Get acceptedAt
     *
     * @return \DateTime
     */
    public function getAcceptedAt()
    {
        return $this->acceptedAt;
    }

    public function setOrganized($organizer)
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getOrganizer()
    {
        return $this->organizer;
    }

    public function cancel()
    {
        $this->setUpdatedAt(new \DateTime());
        $this->setStatus(self::STATUS_CANCELLED);
    }

    public function isCancelled()
    {
        return $this->status == self::STATUS_CANCELLED;
    }

    public function restore()
    {
        $this->setUpdatedAt(new \DateTime());
        $this->setStatus(self::STATUS_NEW);
    }

    public function accept()
    {
        $this->setUpdatedAt(new \DateTime());
        $this->setAcceptedAt(new \DateTime());
        $this->setStatus(self::STATUS_ACCEPTED);
    }

    public function isAccepted()
    {
        return $this->status == self::STATUS_ACCEPTED;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Talk
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set organizer
     *
     * @param string $organizer
     *
     * @return Talk
     */
    public function setOrganizer($organizer)
    {
        $this->organizer = $organizer;

        return $this;
    }
}
