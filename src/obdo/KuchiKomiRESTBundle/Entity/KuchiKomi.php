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
     * @var string
     *
     * @ORM\Column(name="randomId", type="string", length=255)
     */
    private $randomId;
    
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
     * @var integer
     *
     * @ORM\Column(name="origin", type="integer")
     * 
     * origine du kuchikomi 0 = androïd, 1 = iOS, 2 = web, 3 = robot
     */
    private $origin;
    
    /**
     * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Thanks", mappedBy="kuchikomi")
     */
    private $thanks;
    
    /**
     * @var boolean
     *
     * @Expose
     * @Groups({"Synchro"})
     */
    private $isThanks;
    
    private $photoimg; //pour upload photo
    private $deletePhoto;
    
    /**
     * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent", inversedBy="kuchikomis") 
     *
     */
    private $kuchikomirecurrent;
    
                
	

    public function __construct()
    {
        $this->active = true;
        $this->randomId = uniqid('web');
        $this->timestampCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampLastUpdate  = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampSuppression = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->title = "";
        $this->timestampBegin = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampEnd = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->details = "";
        $this->origin = 2;
        $this->resetPhotoLink();
        $this->isThanks = false;
        $this->deletePhoto = false;
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
     * Set randomId
     *
     * @param string $randomId
     * @return string
     */
    public function setRandomId($randomId)
    {
        $this->randomId = $randomId;

        return $this;
    }

    /**
     * Get randomId
     *
     * @return string 
     */
    public function getRandomId()
    {
        return $this->randomId;
    }
    
    public function getOrigin() {
        return $this->origin;
    }

    public function setOrigin($origin) {
        $this->origin = $origin;
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
     * Get timestampEnd in ms
     *
     * @return \DateTime in millisecond
     * @VirtualProperty
     * @Groups({"Synchro"})
     */
    public function getTimestampLastUpdatedMs()
    {
    	return $this->timestampLastUpdate->getTimestamp();
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
    
    public function resetPhotoLink()
    {
        $this->photoLink = "";
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
     * Set isThanks
     *
     * @return boolean
     *
     */
    public function setIsThanks($thanks)
    {
    	$this->isThanks = $thanks;
    
    	return $this;
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
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function updateTitle(){
        $maj = array(
                        "à" => "À",
                        "è" => "È",
                        "ì" => "Ì",
                        "ò" => "Ò",
                        "ù" => "Ù",
                        "á" => "Á",
                        "é" => "É",
                        "í" => "Í",
                        "ó" => "Ó",
                        "ú" => "Ú",
                        "â" => "Â",
                        "ê" => "Ê",
                        "î" => "Î",
                        "ô" => "Ô",
                        "û" => "Û",
                        "ç" => "Ç",
                      );
        // on passe l'initale titre en majuscule!
        $title = $this->getTitle();
        $initale = mb_substr($title, 0, 1, 'UTF-8');
        $suite = mb_substr($title, 1, strlen($title)-1, 'UTF-8');
        if (array_key_exists($initale, $maj)){           
            $title = $maj[$initale].$suite;
        }else{       
            $title[0] = strtoupper($title[0]);
        }
        $this->setTitle($title);
    }    

    /**
     * Add thanks
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Thanks $thanks
     * @return KuchiKomi
     */
    public function addThank(\obdo\KuchiKomiRESTBundle\Entity\Thanks $thanks)
    {
        $this->thanks[] = $thanks;

        return $this;
    }

    /**
     * Remove thanks
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Thanks $thanks
     */
    public function removeThank(\obdo\KuchiKomiRESTBundle\Entity\Thanks $thanks)
    {
        $this->thanks->removeElement($thanks);
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

    /**
     * Set kuchikomirecurrent
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent $kuchikomirecurrent
     * @return KuchiKomi
     */
    public function setKuchikomirecurrent(\obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent $kuchikomirecurrent = null)
    {
        $this->kuchikomirecurrent = $kuchikomirecurrent;

        return $this;
    }

    /**
     * Get kuchikomirecurrent
     *
     * @return \obdo\KuchiKomiRESTBundle\Entity\KuchiKomiRecurrent 
     */
    public function getKuchikomirecurrent()
    {
        return $this->kuchikomirecurrent;
    }
}
