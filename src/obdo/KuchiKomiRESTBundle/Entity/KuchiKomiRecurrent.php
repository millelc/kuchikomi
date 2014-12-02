<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints\Time;



/**
 * KuchiKomiRecurrent
 *
 * @ORM\Table(name = "KuchiKomiRecurrent")
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrentRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @ExclusionPolicy("all")
 * 
 */
class KuchiKomiRecurrent
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
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     * @Expose
     * @Groups({"Synchro"})
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
     * @var string
     *
     * @ORM\Column(name="recurrence", type="string")
     *    
     * weekly , monthly, yearly, unique
     */
    private $recurrence;
    
    
    /**
     *
     * @var \DateTime
     * 
     * @ORM\Column(name="beginTime", type ="time")
     */
    private $beginTime;
    
     /**
     *
     * @var \DateTime
     * 
     * @ORM\Column(name="endTime", type ="time")
     */
    private $endTime;
    
    
     /**
     *
     * @var \DateTime
     * 
     * @ORM\Column(name="endFirstTime", type ="datetime")
     */
    private $endFirstTime;

    /**
     *
     * @var \DateTime 
     * 
     * @ORM\Column(name="beginRecurrence", type="date", nullable = true)
     */
    private $beginRecurrence;

    /**
     *
     * @var \DateTime 
     * 
     * @ORM\Column(name="endRecurrence", type="date", nullable = true)
     */
    private $endRecurrence;
    
        /**
     *
     * @var \DateTime
     * 
     * @ORM\Column(name="dateTimeCreation", type ="datetime")
     */
    private $dateTimeCreation;
    
     /**
     *
     * @var \DateTime
     * 
     * @ORM\Column(name="dateTimeSuppression", type ="datetime", nullable = true)
     */
    private $dateTimeSuppression;
    
    
     /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTimeLastUpdate", type="datetime", nullable = true)
     */
    private $dateTimeLastUpdate;
    
    /**
     *
     * @var integer 
     * 
     * @ORM\Column(name="sendDay", type="integer")
     */
    private $sendDay;



    /**
    * @var array
    *  
    * @ORM\OnetoMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\KuchiKomi", mappedBy="kuchikomirecurrent")    
    */
    private $kuchikomis;
        
    /**
     *
     * @var kuchi
     * 
     * @ORM\ManytoOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Kuchi", inversedBy="kuchikomirecurrents") 
     */
    private $kuchi;
    
    private $photoimg; //pour upload photo
    private $deletePhoto;



    public function __construct()
    {        

        $this->title = "";
        $this->details = "";
        $this->resetPhotoLink();
        $this->deletePhoto = false;        
        $this->beginRecurrence = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->endRecurrence = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->endFirstTime = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->dateTimeCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));    
        $this->kuchikomis = new \Doctrine\Common\Collections\ArrayCollection;  
        $this->endTime = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->beginTime = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->active = true;
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
     * Set $kuchikomis
     *
     * @param array $kuchikomis
     * @return KuchiKomiRecurrent
     */
    public function setKuchikomis($kuchikomis)
    {
        $this->kuchikomis = $kuchikomis               ;

        return $this;
    }

    /**
     * Get $kuchikomis
     *
     * @return array 
     */
    public function getKuchikomis()
    {
        return $this->kuchikomis;
    }

    /**
     * Set $title
     *
     * @param string $title
     * @return KuchiKomiRecurrent
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get $title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set details
     *
     * @param string $details
     * @return KuchiKomiRecurrent
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
     * ReSet $photoLink
     *
     * @param string $photoLink
     * @return KuchiKomiRecurrent
     */
        public function setPhotoLink($photoLink)
    {
        $this->photoLink = $photoLink;

        return $this;
    }
    /**
     * ReSet $photoLink
     *
     * @param string $photoLink
     * @return $this $photoLink
     */
    public function resetPhotoLink()
    {
        $this->photoLink = "";
    }

    /**
     * Get string
     *
     * @return photoLink 
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
     * Set recurrence
     *
     * @param string $recurrence
     * @return KuchiKomiRecurrent
     */
    public function setRecurrence($recurrence)
    {
        $this->recurrence = $recurrence;

        return $this;
    }

    /**
     * Get recurrence
     *
     * @return string 
     */
    public function getRecurrence()
    {
        return $this->recurrence;
    }

    /**
     * Set beginRecurrence
     *
     * @param \DateTime $beginRecurrence
     * @return KuchiKomiRecurrent
     */
    public function setBeginRecurrence($beginRecurrence)
    {
        $this->beginRecurrence = $beginRecurrence;

        return $this;
    }

    /**
     * Get beginRecurrence
     *
     * @return \DateTime 
     */
    public function getBeginRecurrence()
    {
        return $this->beginRecurrence;
    }

    /**
     * Set endRecurrence
     *
     * @param \DateTime $endRecurrence
     * @return KuchiKomiRecurrent
     */
    public function setEndRecurrence($endRecurrence)
    {
        $this->endRecurrence = $endRecurrence;

        return $this;
    }

    /**
     * Get endRecurrence
     *
     * @return \DateTime 
     */
    public function getEndRecurrence()
    {
        return $this->endRecurrence;
    }
    
    
 

    /**
     * Add kuchikomis
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomis
     * @return KuchiKomiRecurrent
     */
    public function addKuchikomi(\obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomis)
    {
        $this->kuchikomis[] = $kuchikomis;

        return $this;
    }

    /**
     * Remove kuchikomis
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomis
     */
    public function removeKuchikomi(\obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomis)
    {
        $this->kuchikomis->removeElement($kuchikomis);
    }

    /**
     * Set kuchi
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchi
     * @return KuchiKomiRecurrent
     */
    public function setKuchi(\obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchi = null)
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
    
    public function getPhotoimg() {
        return $this->photoimg;
    }

    public function setPhotoimg($photoimg) {
        $this->photoimg = $photoimg;
    }
    
    public function getDeletePhoto() 
    {
        return $this->deletePhoto;
    }

    public function setDeletePhoto($deletePhoto) 
    {
        $this->deletePhoto = $deletePhoto;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return KuchiKomiRecurrent
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
    public function isActive()
    {
        return $this->active;
    }

 
        

    /**
     * Set beginTime
     *
     * @param \DateTime $beginTime
     * @return KuchiKomiRecurrent
     */
    public function setBeginTime($beginTime)
    {
        $this->beginTime = $beginTime;
        

        return $this;
    }

    /**
     * Get beginTime
     *
     * @return integer 
     */
    public function getBeginTime()
    {
        return $this->beginTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return KuchiKomiRecurrent
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }


    /**
     * Set sendDay
     *
     * @param integer $sendDay
     * @return KuchiKomiRecurrent
     */
    public function setSendDay($sendDay)
    {
        $this->sendDay = $sendDay;

        return $this;
    }

    /**
     * Get sendDay
     *
     * @return integer 
     */
    public function getSendDay()
    {
        return $this->sendDay;
    }

    /**
     * Set endFirstTime
     *
     * @param \DateTime $endFirstTime
     * @return KuchiKomiRecurrent
     */
    public function setEndFirstTime($endFirstTime)
    {
        $this->endFirstTime = $endFirstTime;

        return $this;
    }

    /**
     * Get endFirstTime
     *
     * @return \DateTime 
     */
    public function getEndFirstTime()
    {
        return $this->endFirstTime;
    }

    /**
     * Set dateTimeCreation
     *
     * @param \DateTime $dateTimeCreation
     * @return KuchiKomiRecurrent
     */
    public function setDateTimeCreation($dateTimeCreation)
    {
        $this->dateTimeCreation = $dateTimeCreation;

        return $this;
    }

    /**
     * Get dateTimeCreation
     *
     * @return \DateTime 
     */
    public function getDateTimeCreation()
    {
        return $this->dateTimeCreation;
    }

    /**
     * Set dateTimeSuppression
     *
     * @param \DateTime $dateTimeSuppression
     * @return KuchiKomiRecurrent
     */
    public function setDateTimeSuppression($dateTimeSuppression)
    {
        $this->dateTimeSuppression = $dateTimeSuppression;

        return $this;
    }

    /**
     * Get dateTimeSuppression
     *
     * @return \DateTime 
     */
    public function getDateTimeSuppression()
    {
        return $this->dateTimeSuppression;
    }

    /**
     * Set dateTimeLastUpdate
     *
     * @param \DateTime $dateTimeLastUpdate
     * @return KuchiKomiRecurrent
     */
    public function setDateTimeLastUpdate($dateTimeLastUpdate)
    {
        $this->dateTimeLastUpdate = $dateTimeLastUpdate;

        return $this;
    }

    /**
     * Get dateTimeLastUpdate
     *
     * @return \DateTime 
     */
    public function getDateTimeLastUpdate()
    {
        return $this->dateTimeLastUpdate;
    }
}
