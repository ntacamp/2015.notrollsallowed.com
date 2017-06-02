<?php

namespace Estina\Bundle\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedule
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Estina\Bundle\HomeBundle\Entity\ScheduleRepository")
 */
class Schedule
{
    const TYPE_TALK = 'talk';
    const TYPE_CUSTOM = 'custom';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Day number 1, 2, etc.
     * @var \DateTime
     *
     * @ORM\Column(name="day", type="integer")
     */
    private $day;

    /**
     * Scheduled time
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="time")
     */
    private $time;

    /**
     * Without track set - schedule entry will be displayed for all tracks.
     *
     * @ORM\ManyToOne(targetEntity="Track")
     * @ORM\JoinColumn(name="track_id", referencedColumnName="id")
     **/
    private $track;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type = self::TYPE_TALK;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Talk")
     * @ORM\JoinColumn(name="talk_id", referencedColumnName="id")
     **/
    private $talk;

    public static function days()
    {
        return [1, 2, 3];
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
     * Set time
     *
     * @param \DateTime $time
     *
     * @return Schedule
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set track
     *
     * @param \Estina\Bundle\HomeBundle\Entity\Track $track
     *
     * @return Schedule
     */
    public function setTrack(\Estina\Bundle\HomeBundle\Entity\Track $track = null)
    {
        $this->track = $track;

        return $this;
    }

    /**
     * Get track
     *
     * @return \Estina\Bundle\HomeBundle\Entity\Track
     */
    public function getTrack()
    {
        return $this->track;
    }

    /**
     * Set talk
     *
     * @param \Estina\Bundle\HomeBundle\Entity\Talk $talk
     *
     * @return Schedule
     */
    public function setTalk(\Estina\Bundle\HomeBundle\Entity\Talk $talk = null)
    {
        $this->talk = $talk;

        return $this;
    }

    /**
     * Get talk
     *
     * @return \Estina\Bundle\HomeBundle\Entity\Talk
     */
    public function getTalk()
    {
        return $this->talk;
    }

    /**
     * Set day
     *
     * @param integer $day
     *
     * @return Schedule
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return integer
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Schedule
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Schedule
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
     * @return Schedule
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
}
