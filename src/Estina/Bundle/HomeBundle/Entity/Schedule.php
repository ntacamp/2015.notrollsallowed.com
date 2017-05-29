<?php

namespace Estina\Bundle\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schedule
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Schedule
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="Track")
     * @ORM\JoinColumn(name="track_id", referencedColumnName="id")
     **/
    private $track;

    /**
     * @ORM\ManyToOne(targetEntity="Talk")
     * @ORM\JoinColumn(name="talk_id", referencedColumnName="id")
     **/
    private $talk;

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
}
