<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * KuchiGroup
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\KuchiGroupRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 * @ExclusionPolicy("all")
 * 
 */
class KuchiGroup
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Expose
     * @Groups({"Synchro"})
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255)
     */
    private $logo;

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
     * @var integer
     *
     * @ORM\Column(name="nbMaxKuchi", type="integer")
     */
    private $nbMaxKuchi;
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Kuchi", mappedBy="kuchiGroup")
    */
    private $kuchis;
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup", mappedBy="kuchiGroup")
    */
    private $subscriptions;
    
    /**
     * @var boolean
     *      
     * @Expose
     * @Groups({"Synchro"})
     */
    private $isSubscribed;
    
    private $logoimg; //pour upload logo
    
    public function __construct()
    {
        $this->active = true;
        $this->timestampCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampLastUpdate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampSuppression = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->nbMaxKuchi = 10;
        $this->logo = "";
        $this->isSubscribed = false;
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
     * Set name
     *
     * @param string $name
     * @return KuchiGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     * @return KuchiGroup
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
     * Set timestampSuppression
     *
     * @param \DateTime $timestampSuppression
     * @return KuchiGroup
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
     * @return KuchiGroup
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
     * Add kuchis
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchis
     * @return KuchiGroup
     */
    public function addKuchi(\obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchis)
    {
        $this->kuchis[] = $kuchis;

        return $this;
    }

    /**
     * Remove kuchis
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchis
     */
    public function removeKuchi(\obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchis)
    {
        $this->kuchis->removeElement($kuchis);
    }

    /**
     * Get kuchis
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getKuchis()
    {
        return $this->kuchis;
    }

    /**
     * Set timestampLastUpdate
     *
     * @param \DateTime $timestampLastUpdate
     * @return KuchiGroup
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
    * @ORM\PreUpdate
    */
    public function updateDate()
    {
        $this->timestampLastUpdate = new \Datetime('now', new \DateTimeZone('Europe/Paris'));
    }

    /**
     * Add subscriptions
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup $subscriptions
     * @return KuchiGroup
     */
    public function addSubscription(\obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup $subscriptions)
    {
        $this->subscriptions[] = $subscriptions;

        return $this;
    }

    /**
     * Remove subscriptions
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup $subscriptions
     */
    public function removeSubscription(\obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup $subscriptions)
    {
        $this->subscriptions->removeElement($subscriptions);
    }

    /**
     * Get subscriptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return KuchiGroup
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return KuchiGroup logo
     */
    public function getLogo()
    {
    	return $this->logo;
    }

    /**
     * Set nbMaxKuchi
     *
     * @param integer $nbMaxKuchi
     * @return KuchiGroup
     */
    public function setNbMaxKuchi($nbMaxKuchi)
    {
        $this->nbMaxKuchi = $nbMaxKuchi;

        return $this;
    }

    /**
     * Get nbMaxKuchi
     *
     * @return integer 
     */
    public function getNbMaxKuchi()
    {
        return $this->nbMaxKuchi;
    }
    
    
    /**
     * Set isSubscribed to true
     *
     * @return boolean
     * 
     */
    public function setSubscribed($subscribe)
    {
    	$this->isSubscribed = $subscribe;
    
    	return $this;
    }
    
    /**
     * Get Logo byte array
     *
     * @return byte array of the logo
     * @VirtualProperty
     * @Groups({"Synchro"})
     */
    public function getLogos()
    {
    	$logoByteStream = "";
    	if( $this->logo != "")
    	{
    		$handle = fopen($this->logo, "r");
    		$contents = fread($handle, filesize($this->logo));
    		fclose($handle);
    		$logoByteStream = base64_encode( $contents );
    	}
    	return $logoByteStream;
    }
    
    public function getLogoimg() {
        return $this->logoimg;
    }

    public function setLogoimg($logoimg) {
        $this->logoimg = $logoimg;
    }


}
