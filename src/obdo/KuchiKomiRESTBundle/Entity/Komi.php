<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * Komi
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\KomiRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @ExclusionPolicy("all")
 */
class Komi
{
    const TOKEN_SIZE = 13;

    const OS_TYPE_ANDROID = 0;
    const OS_TYPE_IOS = 1;
    const OS_TYPE_WINDOWS = 2;
    const OS_TYPE_UNKNOWN = 3;
    
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
     * @ORM\Column(name="randomId", type="string", length=255)
     * @Expose
     * @Groups({"Authenticate"})
     */
    private $randomId;
    
    /**
     * @var text
     *
     * @ORM\Column(name="gcmRegId", type="text")
     */
    private $gcmRegId;    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampCreation", type="datetime")
     */
    private $timestampCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampSuppression", type="datetime")
     */
    private $timestampSuppression;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampLastUpdate", type="datetime")
     */
    private $timestampLastUpdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampLastSynchro", type="datetime")
     */
    private $timestampLastSynchro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampLastSynchroSaved", type="datetime")
     */
    private $timestampLastSynchroSaved;

    /**
     * @var \Integer
     *
     * @ORM\Column(name="osType", type="integer")
     * */
    private $osType;
    
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
     * @Groups({"Authenticate"})
     */
    private $token;
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Subscription", mappedBy="komi")
    */
    private $subscriptions;
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup", mappedBy="komi")
    */
    private $subscriptionsGroup;
    
    /**
     * @var string
     *
     * @ORM\Column(name="applicationVersion", type="string", length=10)
     */
    private $applicationVersion;


    public function __construct()
    {
        $this->active = true;
        $this->timestampCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampLastUpdate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampSuppression = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->resetTimestampLastSynchro();
        $this->generateToken();
        $this->applicationVersion = "0.0.0";
    }

    public function resetTimestampLastSynchro()
    {
    	$this->timestampLastSynchro = new \DateTime('2014-01-01 00:00:00.000000', new \DateTimeZone('Europe/Paris'));
        $this->timestampLastSynchroSaved = new \DateTime('2014-01-01 00:00:00.000000', new \DateTimeZone('Europe/Paris'));
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
     * @return Komi
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

    /**
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     * @return Komi
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
     * @return Komi
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
     * @return Komi
     */
    public function setActive($active)
    {
        if( !$active )
        {
            $this->timestampSuppression = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        }
        
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
     * Set osType
     *
     * @param integer $osType
     * @return Komi
     */
    public function setOsType($osType)
    {
        if($osType==self::OS_TYPE_ANDROID){
            $this->osType = $osType;
        }
        elseif ($osType==self::OS_TYPE_IOS){
            $this->osType = $osType;
        }
        elseif ($osType==self::OS_TYPE_WINDOWS){
            $this->osType = $osType;
        }
        else{
            $this->osType= self::OS_TYPE_UNKNOWN;
        }

        return $this;
    }

    /**
     * Get osType
     *
     * @return integer 
     */
    public function getOsType()
    {
        return $this->osType;
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
     * Add subscriptions
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Subscription $subscriptions
     * @return Komi
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
     * @return Komi
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
     * Set timestampLastSynchro
     *
     * @param \DateTime $timestampLastSynchro
     * @return Komi
     */
    public function setTimestampLastSynchro($timestampLastSynchro)
    {
        $this->timestampLastSynchro = $timestampLastSynchro;

        return $this;
    }
    
    /**
     * Set timestampLastSynchro to current
     *
     * @return Komi
     */
    public function setCurrentTimestampLastSynchroSaved()
    {
    	$this->timestampLastSynchroSaved = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
    
    	return $this;
    }
    
     /**
     * Get timestampLastSynchroSaved
     *
     * @return \DateTime 
     */
    public function getTimestampLastSynchroSaved()
    {
        
        return $this->timestampLastSynchroSaved;
        
    }

        
    /**
     * Validate the last synchro date saved
     *
     * @return Komi
     */
    public function validateLastSynchro()
    {
        $this->timestampLastSynchro = $this->timestampLastSynchroSaved;
    }

    /**
     * Get timestampLastSynchro
     *
     * @return \DateTime 
     */
    public function getTimestampLastSynchro()
    {
        return $this->timestampLastSynchro;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Komi
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set applicationVersion
     *
     * @param string $applicationVersion
     * @return Komi
     */
    public function setApplicationVersion($applicationVersion)
    {
        $this->applicationVersion = $applicationVersion;

        return $this;
    }

    /**
     * Get applicationVersion
     *
     * @return string 
     */
    public function getApplicationVersion()
    {
        return $this->applicationVersion;
    }
    
    /**
    * @ORM\PreUpdate
    */
    public function updateDate()
    {
        $this->timestampLastUpdate = new \Datetime('now', new \DateTimeZone('Europe/Paris'));
    }

    /**
     * Add subscriptionsGroup
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup $subscriptionsGroup
     * @return Komi
     */
    public function addSubscriptionsGroup(\obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup $subscriptionsGroup)
    {
        $this->subscriptionsGroup[] = $subscriptionsGroup;

        return $this;
    }

    /**
     * Remove subscriptionsGroup
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup $subscriptionsGroup
     */
    public function removeSubscriptionsGroup(\obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup $subscriptionsGroup)
    {
        $this->subscriptionsGroup->removeElement($subscriptionsGroup);
    }

    /**
     * Get subscriptionsGroup
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubscriptionsGroup()
    {
        return $this->subscriptionsGroup;
    }

    /**
     * Set gcmRegId
     *
     * @param string $gcmRegId
     * @return Komi
     */
    public function setGcmRegId($gcmRegId)
    {
        $this->gcmRegId = $gcmRegId;

        return $this;
    }

    /**
     * Get gcmRegId
     *
     * @return string 
     */
    public function getGcmRegId()
    {
        return $this->gcmRegId;
    }

    /**
     * Set timestampLastSynchroSaved
     *
     * @param \DateTime $timestampLastSynchroSaved
     * @return Komi
     */
    public function setTimestampLastSynchroSaved($timestampLastSynchroSaved)
    {
        $this->timestampLastSynchroSaved = $timestampLastSynchroSaved;

        return $this;
    }
}
