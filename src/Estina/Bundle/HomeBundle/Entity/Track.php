<?php

namespace Estina\Bundle\HomeBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Track
 *
 * @ORM\Table(name="track", indexes={@ORM\Index(name="track_type", columns={"type", "position"})})
 * @ORM\Entity(repositoryClass="Estina\Bundle\HomeBundle\Entity\TrackRepository")
 */
class Track
{
    const TYPE_TALK = 'TALK';
    const TYPE_WORKSHOP = 'WORK';

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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=4, options={"fixed"=true})
     */
    private $type = self::TYPE_TALK;

    /**
     * @ORM\OneToMany(targetEntity="Talk", mappedBy="track")
     * @ORM\OrderBy({"acceptedAt" = "ASC"})
     *
     * @var array<Talk>
     */
    private $talks;

    public function __construct()
    {
        $this->talks = new ArrayCollection;
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
     * @return Track
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
     * Set size
     *
     * @param integer $size
     *
     * @return Track
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Track
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
     * Set position
     *
     * @param integer $position
     *
     * @return Track
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set track type
     *
     * @param string $type
     *
     * @return Track
     */
    public function setType($type)
    {
        if (!in_array($type, array(self::TYPE_WORKSHOP, self::TYPE_TALK))) {
            throw new \InvalidArgumentException("Invalid type");
        }
        $this->type = $type;

        return $this;
    }

    /**
     * Get track type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * getTalks
     *
     * @return ArrayCollection<Talks>
     */
    public function getTalks()
    {
        return $this->talks;
    }
    public function __toString()
    {
      return $this->title;
    }

    /**
     * Add talk
     *
     * @param \Estina\Bundle\HomeBundle\Entity\Talk $talk
     *
     * @return Track
     */
    public function addTalk(\Estina\Bundle\HomeBundle\Entity\Talk $talk)
    {
        $this->talks[] = $talk;

        return $this;
    }

    /**
     * Remove talk
     *
     * @param \Estina\Bundle\HomeBundle\Entity\Talk $talk
     */
    public function removeTalk(\Estina\Bundle\HomeBundle\Entity\Talk $talk)
    {
        $this->talks->removeElement($talk);
    }

}
