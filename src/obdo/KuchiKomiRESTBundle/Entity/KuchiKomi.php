<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KuchiKomi
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 */
class KuchiKomi
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
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Kuchi", inversedBy="kuchikomis")
    * @ORM\JoinColumn(nullable=false)
    */
    private $kuchi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampCreation", type="datetime")
     */
    private $timestampCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampLastUpdate", type="datetime")
     */
    private $timestampLastUpdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampSuppression", type="datetime")
     */
    private $timestampSuppression;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampBegin", type="datetime")
     */
    private $timestampBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampEnd", type="datetime")
     */
    private $timestampEnd;
    
    
    /**
     * @var text
     *
     * @ORM\Column(name="details", type="text")
     */
    private $details;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="photo_link", type="string", length=255)
     */
    private $photo_link;
    
    
    public function __construct()
    {
        $this->active = true;
        $this->timestampCreation = new \DateTime();
        $this->timestampLastUpdate  = new \DateTime();
        $this->timestampSuppression = new \DateTime();
        $this->title = "";
        $this->timestampBegin = new \DateTime();
        $this->timestampEnd = new \DateTime();
        $this->details = "";
        $this->photo_link = "";
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
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     * @return KuchiKomi
     */
    public function setTimestampCreation($timestampCreation)
    {
        $this->timestampCreation = $timestampCreation;

        return $this;
    }

    /**
     * Get timestampCreation
     *
     * @return \DateTime 
     */
    public function getTimestampCreation()
    {
        return $this->timestampCreation;
    }

    /**
     * Set timestampLastUpdate
     *
     * @param \DateTime $timestampLastUpdate
     * @return KuchiKomi
     */
    public function setTimestampLastUpdate($timestampLastUpdate)
    {
        $this->timestampLastUpdate = $timestampLastUpdate;

        return $this;
    }

    /**
     * Get timestampLastUpdate
     *
     * @return \DateTime 
     */
    public function getTimestampLastUpdate()
    {
        return $this->timestampLastUpdate;
    }

    /**
     * Set timestampSuppression
     *
     * @param \DateTime $timestampSuppression
     * @return KuchiKomi
     */
    public function setTimestampSuppression($timestampSuppression)
    {
        $this->timestampSuppression = $timestampSuppression;

        return $this;
    }

    /**
     * Get timestampSuppression
     *
     * @return \DateTime 
     */
    public function getTimestampSuppression()
    {
        return $this->timestampSuppression;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return KuchiKomi
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
    
    /**
    * @ORM\PreUpdate
    */
    public function updateDate()
    {
        $this->timestampLastUpdate = new \Datetime();
    }

    /**
     * Set kuchi
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchi
     * @return KuchiKomi
     */
    public function setKuchi(\obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchi)
    {
        $this->kuchi = $kuchi;

        return $this;
    }

    /**
     * Get kuchi
     *
     * @return \obdo\KuchiKomiRESTBundle\Entity\Kuchi 
     */
    public function getKuchi()
    {
        return $this->kuchi;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return KuchiKomi
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
     * Set timestampBegin
     *
     * @param \DateTime $timestampBegin
     * @return KuchiKomi
     */
    public function setTimestampBegin($timestampBegin)
    {
        $this->timestampBegin = $timestampBegin;

        return $this;
    }

    /**
     * Get timestampBegin
     *
     * @return \DateTime 
     */
    public function getTimestampBegin()
    {
        return $this->timestampBegin;
    }

    /**
     * Set timestampEnd
     *
     * @param \DateTime $timestampEnd
     * @return KuchiKomi
     */
    public function setTimestampEnd($timestampEnd)
    {
        $this->timestampEnd = $timestampEnd;

        return $this;
    }

    /**
     * Get timestampEnd
     *
     * @return \DateTime 
     */
    public function getTimestampEnd()
    {
        return $this->timestampEnd;
    }

    /**
     * Set details
     *
     * @param string $details
     * @return KuchiKomi
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set photo_link
     *
     * @param string $photoLink
     * @return KuchiKomi
     */
    public function setPhotoLink($photoLink)
    {
        $this->photo_link = $photoLink;

        return $this;
    }

    /**
     * Get photo_link
     *
     * @return string 
     */
    public function getPhotoLink()
    {
        return $this->photo_link;
    }
}
