<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;


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
     * w = weekly , m = monthly
     */
    private $recurrence;

    /**
     *
     * @var \DateTime 
     * 
     * @ORM\Column(name="beginRecurrence", type="datetime", nullable = true)
     */
    private $beginRecurrence;

    /**
     *
     * @var \DateTime 
     * 
     * @ORM\Column(name="endRecurrence", type="datetime", nullable = true)
     */
    private $endRecurrence;
    
    
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



    public function __construct()
    {        

        $this->title = "";
        $this->details = "";
        $this->resetPhotoLink();
        $this->deletePhoto = false;        
        $this->beginRecurrence = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->endRecurrence = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->kuchikomis = new \Doctrine\Common\Collections\ArrayCollection;
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
}
