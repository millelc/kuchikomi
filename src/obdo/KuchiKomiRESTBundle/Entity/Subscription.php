<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use obdo\KuchiKomiRESTBundle\Entity\SubscriptionBase;

/**
 * Subscription
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\SubscriptionRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 */
class Subscription extends SubscriptionBase
{        
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Komi", inversedBy="subscriptions")
    */
    private $komi;

    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Kuchi", inversedBy="subscriptions")
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
     * @var \Integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;
    
    public function __construct()
    {
        $this->active = true;
        $this->timestampCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampLastUpdate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampSuppression = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->type = self::TYPE_WEB;
    }


    /**
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     * @return Subscription
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
     * @return Subscription
     */
    public function setTimestampSuppression($timestampSuppression)
    {
        $this->timestampSuppression = $timestampSuppression;

        return $this;
    }

    /**
     * Set timestampSuppression to current
     *
     * @return Subscription
     */
    public function setCurrentTimestampSuppression()
    {
        $this->timestampSuppression = new \DateTime('now', new \DateTimeZone('Europe/Paris'));

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
     * @return Subscription
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
     * Set komi
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Komi $komi
     * @return Subscription
     */
    public function setKomi(\obdo\KuchiKomiRESTBundle\Entity\Komi $komi)
    {
        $this->komi = $komi;

        return $this;
    }

    /**
     * Get komi
     *
     * @return \obdo\KuchiKomiRESTBundle\Entity\Komi 
     */
    public function getKomi()
    {
        return $this->komi;
    }

    /**
     * Set kuchi
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Kuchi $kuchi
     * @return Subscription
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
     * Set type
     *
     * @param integer $type
     * @return Subscription
     */
    public function setType($type)
    {
        $this->type = $this->getRegisteredType($type);

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set timestampLastUpdate
     *
     * @param \DateTime $timestampLastUpdate
     * @return Subscription
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
}
