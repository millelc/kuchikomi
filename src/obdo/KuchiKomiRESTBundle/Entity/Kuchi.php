<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Security\Core\Util\SecureRandom;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Entity\Subscription;

/**
 * Kuchi
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\KuchiRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @ExclusionPolicy("all")
 * 
 */
class Kuchi
{
    const TOKEN_SIZE = 13;
        
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\KuchiGroup", inversedBy="kuchis")
    * @ORM\JoinColumn(nullable=false)
    */
    private $kuchiGroup;
  
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
     * @ORM\Column(name="token", type="string", length=26)
     * @Expose
     */
    private $token;

    /**
     * @var text
     *
     * @ORM\Column(name="password", type="text")
     */
    private $password;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="logo_link", type="string", length=255)
     */
    private $logo_link;
    
        /**
     * @var string
     *
     * @ORM\Column(name="photo_link", type="string", length=255)
     */
    private $photo_link;
    
    
    /**
    * @ORM\OneToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Address", cascade={"persist"})
    */
    private $address;
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Subscription", mappedBy="kuchi")
    */
    private $subscriptions;
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\KuchiKomi", mappedBy="kuchi")
    */
    private $kuchikomis;

    public function __construct()
    {
        $this->active = true;
        $this->timestampCreation = new \DateTime();
        $this->timestampLastUpdate  = new \DateTime();
        $this->timestampSuppression = new \DateTime();
        $this->generateToken();
        $this->logo_link = "";
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
     * @return Kuchi
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
     * @return Kuchi
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
     * @return Kuchi
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
     * Set token
     *
     * @param string $token
     * @return Komi
     */
    public function generateToken()
    {
        $generator = new SecureRandom();
        $this->token = bin2hex($generator->nextBytes( self::TOKEN_SIZE ));

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Kuchi
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
     * Set kuchiGroup
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\KuchiGroup $kuchiGroup
     * @return Kuchi
     */
    public function setKuchiGroup(\obdo\KuchiKomiRESTBundle\Entity\KuchiGroup $kuchiGroup)
    {
        $this->kuchiGroup = $kuchiGroup;

        return $this;
    }

    /**
     * Get kuchiGroup
     *
     * @return \obdo\KuchiKomiRESTBundle\Entity\KuchiGroup 
     */
    public function getKuchiGroup()
    {
        return $this->kuchiGroup;
    }

    /**
     * Add subscriptions
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Subscription $subscriptions
     * @return Kuchi
     */
    public function addSubscription(\obdo\KuchiKomiRESTBundle\Entity\Subscription $subscriptions)
    {
        $this->subscriptions[] = $subscriptions;

        return $this;
    }

    /**
     * Remove subscriptions
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Subscription $subscriptions
     */
    public function removeSubscription(\obdo\KuchiKomiRESTBundle\Entity\Subscription $subscriptions)
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
     * Set timestampLastUpdate
     *
     * @param \DateTime $timestampLastUpdate
     * @return Kuchi
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
        $this->timestampLastUpdate = new \Datetime();
    }

    /**
     * Add kuchikomis
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomis
     * @return Kuchi
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
     * Get kuchikomis
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getKuchikomis()
    {
        return $this->kuchikomis;
    }

    /**
     * Set address
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Address $address
     * @return Kuchi
     */
    public function setAddress(\obdo\KuchiKomiRESTBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }
    

    /**
     * Get address
     *
     * @return \obdo\KuchiKomiRESTBundle\Entity\Address 
     */
    public function getAddress()
    {
        return $this->address;
    }


    /**
     * Set token
     *
     * @param string $token
     * @return Kuchi
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set logo_link
     *
     * @param string $logoLink
     * @return Kuchi
     */
    public function setLogoLink($logoLink)
    {
        $this->logo_link = $logoLink;

        return $this;
    }

    /**
     * Get logo_link
     *
     * @return string 
     */
    public function getLogoLink()
    {
        return $this->logo_link;
    }

    /**
     * Set photo_link
     *
     * @param string $photoLink
     * @return Kuchi
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

    /**
     * Set password
     *
     * @param string $password
     * @return Kuchi
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
}
