<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubscriptionGroup
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroupRepository")
 * @ORM\HasLifecycleCallbacks()
 * 
 */
class SubscriptionGroup
{
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Komi", inversedBy="subscriptionsGroup")
    */
    private $komi;

    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\KuchiGroup", inversedBy="subscriptions")
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
    }
    

    /**
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     * @return SubscriptionGroup
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
     * @return SubscriptionGroup
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
     * @return SubscriptionGroup
     */
    public function setTimestampSuppression($timestampSuppression)
    {
        $this->timestampSuppression = $timestampSuppression;

        return $this;
    }

    /**
     * Set timestampSuppression to current
     *
     * @return SubscriptionGroup
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
     * @return SubscriptionGroup
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
    * @ORM\PreUpdate
    */
    public function updateDate()
    {
        $this->timestampLastUpdate = new \Datetime('now', new \DateTimeZone('Europe/Paris'));
    }

    /**
     * Set komi
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Komi $komi
     * @return SubscriptionGroup
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
     * Set kuchiGroup
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\KuchiGroup $kuchiGroup
     * @return SubscriptionGroup
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
     * Set type
     *
     * @param integer $type
     * @return SubscriptionGroup
     */
    public function setType($type)
    {
        $this->type = $type;

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
}
