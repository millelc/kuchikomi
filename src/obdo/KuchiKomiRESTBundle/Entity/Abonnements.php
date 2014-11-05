<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Abonnements
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\AbonnementsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Abonnements
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
     * @ORM\Column(name="titreabo", type="string", length=255)
     */
    private $titreabo;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbMaxKuchi", type="integer")
     */
    private $nbMaxKuchi;

    /**
     * @var string
     *
     * @ORM\Column(name="nomgrpKuchi", type="string", length=255)
     */
    private $nomgrpKuchi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebabo", type="date")
     */
    private $datedebabo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefinabo", type="date")
     */
    private $datefinabo;

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
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Clients", inversedBy="abonnements")
    */
    private $client;
    
    /**
    * @ORM\OneToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Kuchi", mappedBy="abonnement")
    */
    private $kuchis;
    
    public function __construct()
    {
        $this->timestampCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampLastUpdate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->timestampSuppression = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->kuchis = new ArrayCollection();
    }
    
    public function getKuchis() {
        return $this->kuchis;
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
     * Set titreabo
     *
     * @param string $titreabo
     * @return Abonnements
     */
    public function setTitreabo($titreabo)
    {
        $this->titreabo = $titreabo;

        return $this;
    }

    /**
     * Get titreabo
     *
     * @return string 
     */
    public function getTitreabo()
    {
        return $this->titreabo;
    }

    /**
     * Set nbMaxKuchi
     *
     * @param integer $nbMaxKuchi
     * @return Abonnements
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
     * Set nomgrpKuchi
     *
     * @param string $nomgrpKuchi
     * @return Abonnements
     */
    public function setNomgrpKuchi($nomgrpKuchi)
    {
        $this->nomgrpKuchi = $nomgrpKuchi;

        return $this;
    }

    /**
     * Get nomgrpKuchi
     *
     * @return string 
     */
    public function getNomgrpKuchi()
    {
        return $this->nomgrpKuchi;
    }

    /**
     * Set datedebabo
     *
     * @param \DateTime $datedebabo
     * @return Abonnements
     */
    public function setDatedebabo($datedebabo)
    {
        $this->datedebabo = $datedebabo;

        return $this;
    }

    /**
     * Get datedebabo
     *
     * @return \DateTime 
     */
    public function getDatedebabo()
    {
        return $this->datedebabo;
    }

    /**
     * Set datefinabo
     *
     * @param \DateTime $datefinabo
     * @return Abonnements
     */
    public function setDatefinabo($datefinabo)
    {
        $this->datefinabo = $datefinabo;

        return $this;
    }

    /**
     * Get datefinabo
     *
     * @return \DateTime 
     */
    public function getDatefinabo()
    {
        return $this->datefinabo;
    }

    /**
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     * @return Abonnements
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
     * @return Abonnements
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
     * @return Abonnements
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
    
    public function getClient() {
        return $this->client;
    }

    public function setClient($client) {
        $this->client = $client;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function updateDate(){
        // on renseigne la date de mise à jour avec la date système lors .... d'une mise à jour !
        $this->setTimestampLastUpdate(new \Datetime());
    }
}
