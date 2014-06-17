<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
// pour la validation
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Clients
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\ClientsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Clients
{
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
     * @ORM\Column(name="raissoc", type="string", length=100)
     */
    private $raissoc;

    /**
     * @var string
     *
     * @ORM\Column(name="telcli", type="string", length=50)
     */
    private $telcli;

    /**
     * @var string
     *
     * @ORM\Column(name="mailcli", type="string", length=100)
     */
    private $mailcli;

    /**
     * @var string
     *
     * @ORM\Column(name="ruecli", type="string", length=255)
     */
    private $ruecli;

    /**
     * @var string
     *
     * @ORM\Column(name="noruecli", type="string", length=20)
     */
    private $noruecli;

    /**
     * @var string
     *
     * @ORM\Column(name="codposcli", type="string", length=10)
     * @Assert\Regex(pattern = "/^[0-9]{5,5}$/", message = "Code postal erroné")
     */
    private $codposcli;

    /**
     * @var string
     *
     * @ORM\Column(name="villecli", type="string", length=255)
     */
    private $villecli;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nomcontact", type="string", length=100, nullable=true)
     */
    private $nomcontact;

    /**
     * @var string
     *
     * @ORM\Column(name="titrecontact", type="string", length=20, nullable=true)
     */
    private $titrecontact;

    /**
     * @var string
     *
     * @ORM\Column(name="telcontact", type="string", length=50, nullable=true)
     */
    private $telcontact;

    /**
     * @var string
     *
     * @ORM\Column(name="mailcontact", type="string", length=100, nullable=true)
     */
    private $mailcontact;

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
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiUserBundle\Entity\User", mappedBy="object")
    */
    private $users;
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Abonnements", mappedBy="Abonnements")
    */
    private $abonnements;
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Appels", mappedBy="client")
    */
    private $appels;

    public function __construct()
    {
        $this->timestampCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampLastUpdate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampSuppression = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->users = new ArrayCollection();
    }
    
    public function getUsers() 
    {
    return $this->users;
    }
  
    /**
     * Get abonnements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAbonnements() {
        return $this->abonnements;
    }
    
    /**
     * Add abonnements
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Abonnements $abonnements
     * @return Clients
     */
    public function addAbonnement(\obdo\KuchiKomiRESTBundle\Entity\Abonnements $abonnements)
    {
        $this->abonnements[] = $abonnements;

        return $this;
    }
    
    /**
     * Remove abonnements
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Abonnements $abonnements
     */
    public function removeAbonnement(\obdo\KuchiKomiRESTBundle\Entity\Abonnements $abonnements)
    {
        $this->abonnements->removeElement($abonnements);
    }
    
    /**
     * Get appels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAppels() {
        return $this->appels;
    }
    
    /**
     * Add appel
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Appels $appels
     * @return Clients
     */
    public function addAppel(\obdo\KuchiKomiRESTBundle\Entity\Appels $appels)
    {
        $this->appels[] = $appels;

        return $this;
    }
    
    /**
     * Remove appel
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\Appels $appels
     */
    public function removeAppel(\obdo\KuchiKomiRESTBundle\Entity\Appels $appels)
    {
        $this->appels->removeElement($appels);
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
     * Set raissoc
     *
     * @param string $raissoc
     * @return Clients
     */
    public function setRaissoc($raissoc)
    {
        $this->raissoc = $raissoc;

        return $this;
    }

    /**
     * Get raissoc
     *
     * @return string 
     */
    public function getRaissoc()
    {
        return $this->raissoc;
    }

    /**
     * Set telcli
     *
     * @param string $telcli
     * @return Clients
     */
    public function setTelcli($telcli)
    {
        $this->telcli = $telcli;

        return $this;
    }

    /**
     * Get telcli
     *
     * @return string 
     */
    public function getTelcli()
    {
        return $this->telcli;
    }

    /**
     * Set mailcli
     *
     * @param string $mailcli
     * @return Clients
     */
    public function setMailcli($mailcli)
    {
        $this->mailcli = $mailcli;

        return $this;
    }

    /**
     * Get mailcli
     *
     * @return string 
     */
    public function getMailcli()
    {
        return $this->mailcli;
    }

    /**
     * Set ruecli
     *
     * @param string $ruecli
     * @return Clients
     */
    public function setRuecli($ruecli)
    {
        $this->ruecli = $ruecli;

        return $this;
    }

    /**
     * Get ruecli
     *
     * @return string 
     */
    public function getRuecli()
    {
        return $this->ruecli;
    }

    /**
     * Set noruecli
     *
     * @param string $noruecli
     * @return Clients
     */
    public function setNoruecli($noruecli)
    {
        $this->noruecli = $noruecli;

        return $this;
    }

    /**
     * Get noruecli
     *
     * @return string 
     */
    public function getNoruecli()
    {
        return $this->noruecli;
    }

    /**
     * Set codposcli
     *
     * @param string $codposcli
     * @return Clients
     */
    public function setCodposcli($codposcli)
    {
        $this->codposcli = $codposcli;

        return $this;
    }

    /**
     * Get codposcli
     *
     * @return string 
     */
    public function getCodposcli()
    {
        return $this->codposcli;
    }
    
    public function getVillecli() {
        return $this->villecli;
    }

    public function setVillecli($villecli) {
        $this->villecli = $villecli;
    }

        /**
     * Set nomcontact
     *
     * @param string $nomcontact
     * @return Clients
     */
    public function setNomcontact($nomcontact)
    {
        $this->nomcontact = $nomcontact;

        return $this;
    }

    /**
     * Get nomcontact
     *
     * @return string 
     */
    public function getNomcontact()
    {
        return $this->nomcontact;
    }

    /**
     * Set titrecontact
     *
     * @param string $titrecontact
     * @return Clients
     */
    public function setTitrecontact($titrecontact)
    {
        $this->titrecontact = $titrecontact;

        return $this;
    }

    /**
     * Get titrecontact
     *
     * @return string 
     */
    public function getTitrecontact()
    {
        return $this->titrecontact;
    }

    /**
     * Set telcontact
     *
     * @param string $telcontact
     * @return Clients
     */
    public function setTelcontact($telcontact)
    {
        $this->telcontact = $telcontact;

        return $this;
    }

    /**
     * Get telcontact
     *
     * @return string 
     */
    public function getTelcontact()
    {
        return $this->telcontact;
    }

    /**
     * Set mailcontact
     *
     * @param string $mailcontact
     * @return Clients
     */
    public function setMailcontact($mailcontact)
    {
        $this->mailcontact = $mailcontact;

        return $this;
    }

    /**
     * Get mailcontact
     *
     * @return string 
     */
    public function getMailcontact()
    {
        return $this->mailcontact;
    }

    /**
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     * @return Clients
     */
    public function setTimestampCreation($timestampCreation)
    {
        $this->timestampCreation = $datecreation;

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
     * @return Clients
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
     * @return Clients
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
     * @ORM\PreUpdate
     */
    public function updateDate(){
        // on renseigne la date de mise à jour avec la date système lors .... d'une mise à jour !
        $this->setTimestampLastUpdate(new \Datetime());
    }
}
