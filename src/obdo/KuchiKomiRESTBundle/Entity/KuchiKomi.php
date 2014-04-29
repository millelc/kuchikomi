<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * KuchiKomi
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @ExclusionPolicy("all")
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
     * @Expose
     * @Groups({"Synchro"})
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
     * @Expose
     * @Groups({"Synchro"})
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
     * @ORM\Column(name="details", type="text", nullable=true)
     * @Expose
     * @Groups({"Synchro"})
     */
    private $details;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="photoLink", type="string", length=255, nullable=true)
     */
    private $photoLink;
    
    /**
     * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Thanks", mappedBy="kuchikomi")
     */
    private $thanks;
    
    
    public function __construct()
    {
        $this->active = true;
        $this->timestampCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampLastUpdate  = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampSuppression = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->title = "";
        $this->timestampBegin = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampEnd = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->details = "";
        $this->photoLink = "";
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
        $this->timestampLastUpdate = new \Datetime('now', new \DateTimeZone('Europe/Paris'));
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
     * Get kuchiId
     *
     * @return Id of the kuchi
     * @VirtualProperty
     * @Groups({"Synchro"})
     */
    public function getKuchiId()
    {
    	return $this->kuchi->getId();
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
     * Get timestampBegin in ms
     *
     * @return \DateTime in millisecond
     * @VirtualProperty
     * @Groups({"Synchro"})
     */
    public function getTimestampBeginMs()
    {
    	return $this->timestampBegin->getTimestamp();
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
     * Get timestampEnd in ms
     *
     * @return \DateTime in millisecond
     * @VirtualProperty
     * @Groups({"Synchro"})
     */
    public function getTimestampEndMs()
    {
    	return $this->timestampEnd->getTimestamp();
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
        $this->photoLink = $photoLink;

        return $this;
    }

    /**
     * Get photo_link
     *
     * @return string 
     */
    public function getPhotoLink()
    {
        return $this->photoLink;
    }
    

    /**
     * Get Photo byte array
     *
     * @return byte array of the photo
     * @VirtualProperty
     * @Groups({"Synchro"})
     */
    public function getPhoto()
    {
    	$photoByteStream = "";
		if( $this->photoLink != "")
		{
			$handle = fopen($this->photoLink, "r");
     		$contents = fread($handle, filesize($this->photoLink));
     		fclose($handle);
     		$photoByteStream = base64_encode( $contents );
		}
     	return $photoByteStream;
    }
    
    /**
     * Get Nb thanks
     *
     * @return number of thanks
     * @VirtualProperty
     * @Groups({"Synchro"})
     */
    public function getNbThanks()
    {
    	return count($this->thanks);
    }
    
    /**
     * Get thanks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getThanks()
    {
        return $this->thanks;
    }
}
