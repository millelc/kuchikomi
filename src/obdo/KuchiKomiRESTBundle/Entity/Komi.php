<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * Komi
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\KomiRepository")
 *
 * @ExclusionPolicy("all")
 */
class Komi
{
    const TOKEN_SIZE = 13;
    
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
     * @ORM\Column(name="timestampSuppression", type="datetime")
     */
    private $timestampSuppression;

    /**
     * @var \Integer
     *
     * @ORM\Column(name="osType", type="integer")
     */
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
     */
    private $token;
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Subscription", mappedBy="komi")
    */
    private $subscriptions;
    
    private $tokenSize;



    public function __construct()
    {
        $this->active = true;
        $this->timestampCreation = new \DateTime();
        $this->timestampSuppression = new \DateTime();
        $this->generateToken();
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
        $this->osType = $osType;

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
}
