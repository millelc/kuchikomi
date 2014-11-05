<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use Doctrine\Common\Collections\ArrayCollection;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Entity\Subscription;
use obdo\KuchiKomiUserBundle\Entity\User;
// pour la validation
use Symfony\Component\Validator\Constraints as Assert;

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
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     * @Groups({"Authenticate","Synchro"})
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
     * @var text
     *
     * @ORM\Column(name="password", type="text")
     */
    private $password;
    
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
     * @ORM\Column(name="logoLink", type="string", length=255)
     */
    private $logoLink;
    
     /**
     * @var string
     *
     * @ORM\Column(name="photoLink", type="string", length=255)
     */
    private $photoLink;

    /**
     * @var string
     *
     * @ORM\Column(name="photoKuchiKomiFolder", type="string", length=255)
     */
    private $photoKuchiKomiFolder;
    
    /**
    * @ORM\OneToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Address", cascade={"persist"})
    * @Expose
    * @Groups({"Synchro"})
    *
    *@Assert\Valid()  
    */
    private $address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="mailAddress", type="string", length=255, nullable=true)
     * @Expose
     * @Groups({"Synchro"})
     * 
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas un email valide.")
     */
    private $mailAddress;
    
    /**
     * @var string
     *
     * @ORM\Column(name="webSite", type="string", length=255, nullable=true)
     * @Expose
     * @Groups({"Synchro"})
     * 
     * @Assert\Url()
     */
    private $webSite;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=50)
     * @Expose
     * @Groups({"Synchro"})
     */
    private $phoneNumber;
    
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Subscription", mappedBy="kuchi")
    */
    private $subscriptions;
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\KuchiKomi", mappedBy="kuchi")
    */
    private $kuchikomis;
    
    /**
    * @ORM\Column(type="integer", nullable=true)
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Abonnements", inversedBy="kuchis")
    */
    private $abonnement;
    
    private $logoimg; //pour upload logo
    private $photoimg; //pour upload photo

    /**
     * @var ArrayCollection Kuchi $users
     *
     * Inverse Side
     *
     * @ORM\ManyToMany(targetEntity="obdo\KuchiKomiUserBundle\Entity\User", mappedBy="kuchis", cascade={"all"})
     */
    private $users;
    
    public function __construct()
    {
        $this->active = true;
        $this->timestampCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampLastUpdate  = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampSuppression = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->logoLink = "";
        $this->photoLink = "";
        $this->photoKuchiKomiFolder = "";
        $this->phoneNumber = "";
        $this->mailAddress = "";
        $this->webSite = "";
        $this->users = new ArrayCollection();
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
     * Get kuchiGroupId
     *
     * @return Id of the kuchi group 
     * @VirtualProperty 
     * @Groups({"Synchro"})
     */
    public function getKuchiGroupId()
    {
        return $this->kuchiGroup->getId();
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
     * Get number of active subscriptions
     *
     * @return number
     */
    public function getNbSubscriptionsActive()
    {
    	$result = 0;
    	foreach ($this->subscriptions as $subscription)
    	{
            if( $subscription->getActive() )
            {
                $result = $result + 1;
            }
    	}
        
    	return $result;
    }
    
    /**
     * Get number of active subscriptions
     *
     * @return number
     */
    public function getNbSubscriptionsAll()
    {
    	return count($this->subscriptions);
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
        $this->timestampLastUpdate = new \Datetime('now', new \DateTimeZone('Europe/Paris'));
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
     * Set logo_link
     *
     * @param string $logoLink
     * @return Kuchi
     */
    public function setLogoLink($logoLink)
    {
        $this->logoLink = $logoLink;

        return $this;
    }

    /**
     * Get logo_link
     *
     * @return string 
     */
    public function getLogoLink()
    {
        return $this->logoLink;
    }

    /**
     * Set photo_link
     *
     * @param string $photoLink
     * @return Kuchi
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
     * Set photoKuchiKomiLink
     *
     * @param string $photoKuchiKomiLink
     * @return Kuchi
     */
    public function setPhotoKuchiKomiLink($photoKuchiKomiLink)
    {
        $this->photoKuchiKomiFolder = $photoKuchiKomiLink;

        return $this;
    }

    /**
     * Get photoKuchiKomiLink
     *
     * @return string 
     */
    public function getPhotoKuchiKomiLink()
    {
        return $this->photoKuchiKomiFolder;
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
    
    /**
     * Get Logo byte array
     *
     * @return byte array of the logo
     * @VirtualProperty
     * @Groups({"Synchro"})
     */
    public function getLogo()
    {
    	$logoByteStream = "";
    	if( $this->logoLink != "")
    	{
    		$handle = fopen($this->logoLink, "r");
    		$contents = fread($handle, filesize($this->logoLink));
    		fclose($handle);
    		$logoByteStream = base64_encode( $contents );
    	}
    	return $logoByteStream;
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
     * Set photoKuchiKomiFolder
     *
     * @param string $photoKuchiKomiFolder
     * @return Kuchi
     */
    public function setPhotoKuchiKomiFolder($photoKuchiKomiFolder)
    {
        $this->photoKuchiKomiFolder = $photoKuchiKomiFolder;

        return $this;
    }

    /**
     * Get photoKuchiKomiFolder
     *
     * @return string 
     */
    public function getPhotoKuchiKomiFolder()
    {
        return $this->photoKuchiKomiFolder;
    }

    /**
     * Set mailAddress
     *
     * @param string $mailAddress
     * @return Kuchi
     */
    public function setMailAddress($mailAddress)
    {
        $this->mailAddress = $mailAddress;

        return $this;
    }

    /**
     * Get mailAddress
     *
     * @return string 
     */
    public function getMailAddress()
    {
        return $this->mailAddress;
    }

    /**
     * Set webSite
     *
     * @param string $webSite
     * @return Kuchi
     */
    public function setWebSite($webSite)
    {
        $this->webSite = $webSite;

        return $this;
    }

    /**
     * Get webSite
     *
     * @return string 
     */
    public function getWebSite()
    {
        return $this->webSite;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return Kuchi
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    
    public function getLogoimg() {
        return $this->logoimg;
    }

    public function setLogoimg($logoimg) {
        $this->logoimg = $logoimg;
    }
    
    public function getPhotoimg() {
        return $this->photoimg;
    }

    public function setPhotoimg($photoimg) {
        $this->photoimg = $photoimg;
    }
    
    public function addUser(User $user)
    {
        // Si l'objet fait déjà partie de la collection on ne l'ajoute pas
        if (!$this->users->contains($user)) {
            if (!$user->getKuchis()->contains($this)) {
                $user->addKuchi($this);  
            }
            $this->users->add($user);
        }
    }
 
    public function setUsers($items)
    {
        if ($items instanceof ArrayCollection || is_array($items)) {
            foreach ($items as $item) {
                $this->addUser($item);
            }
        } elseif ($items instanceof User) {
            $this->addUser($items);
        } else {
            throw new Exception("$items must be an instance of User or ArrayCollection");
        }
    }
 
    /**
     * Get ArrayCollection
     *
     * @return ArrayCollection $users
     */
    public function getUsers()
    {
        return $this->users;
    }
    
    public function getAbonnement() {
        return $this->abonnement;
    }

    public function setAbonnement($abonnement) {
        $this->abonnement = $abonnement;
    }

}
