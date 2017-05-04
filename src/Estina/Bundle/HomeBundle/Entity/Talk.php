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
     * @var string
     *
     * Optional pre-requirements for talk attendees.
     *
     * @ORM\Column(name="requirements", type="text", nullable=true)
     */
    private $requirements;

    /**
     * @var string
     *
     * Comments, special requests for organizers.
     *
     * @ORM\Column(name="comments", type="text")
     */
    private $comments;

    /**
     * Requested duration for the talk.
     *
     * @ORM\Column(name="duration", type="string", length=64, nullable=true)
     * @Assert\Length(max="64")
     **/
    private $durationRequest;

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
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20)
     */
    private $status = self::STATUS_NEW;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="language", type="string", length=20, nullable=false)
     */
    private $language;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="tshirt_size", type="string", length=5, nullable=false)
     */
    private $tshirtSize;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="tshirt_model", type="string", length=10, nullable=false)
     */
    private $tshirtModel;

    /**
     * Talk type (workshop, presentation, etc.)
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="type", type="string", length=20, nullable=false)
     */
    private $type;

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

    public function getOrganizer()
    {
        return $this->organizer;
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

    /**
     * Getter for type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Setter for type
     *
     * @param string $type
     * @return Talk
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Getter for requirements
     *
     * @return string
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Setter for requirements
     *
     * @param string $requirements
     * @return Talk
     */
    public function setRequirements($requirements)
    {
        $this->requirements = $requirements;

        return $this;
    }

    /**
     * Getter for duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Setter for duration
     *
     * @param string $duration
     * @return Talk
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Getter for comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Setter for comments
     *
     * @param string $comments
     * @return Talk
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Getter for tshirtSize
     *
     * @return string
     */
    public function getTshirtSize()
    {
        return $this->tshirtSize;
    }

    /**
     * Setter for tshirtSize
     *
     * @param string $tshirtSize
     * @return Talk
     */
    public function setTshirtSize($tshirtSize)
    {
        $this->tshirtSize = $tshirtSize;

        return $this;
    }

    /**
     * Getter for tshirtModel
     *
     * @return string
     */
    public function getTshirtModel()
    {
        return $this->tshirtModel;
    }

    /**
     * Setter for tshirtModel
     *
     * @param string $tshirtModel
     * @return Talk
     */
    public function setTshirtModel($tshirtModel)
    {
        $this->tshirtModel = $tshirtModel;

        return $this;
    }
}
