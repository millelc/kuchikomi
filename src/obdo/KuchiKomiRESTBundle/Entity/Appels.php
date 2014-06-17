<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Appels
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\AppelsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Appels
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateappel", type="datetime")
     */
    private $dateappel;

    /**
     * @var string
     *
     * @ORM\Column(name="nomcorresp", type="string", length=80)
     */
    private $nomcorresp;

    /**
     * @var string
     *
     * @ORM\Column(name="telcorresp", type="string", length=50, nullable=true)
     */
    private $telcorresp;

    /**
     * @var string
     *
     * @ORM\Column(name="titreappel", type="string", length=80)
     */
    private $titreappel;

    /**
     * @var string
     *
     * @ORM\Column(name="raisonappel", type="text")
     */
    private $raisonappel;

    /**
     * @var string
     *
     * @ORM\Column(name="solution", type="text")
     */
    private $solution;

    /**
     * @var integer
     *
     * @ORM\Column(name="temps", type="integer")
     */
    private $temps;

    /**
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Clients", inversedBy="appels")
    */
    private $client;
    
    /**
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\TypeAppel", inversedBy="appels")
    */
    private $typeappel;
    
    public function __construct()
    {
        $this->dateappel = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
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
     * Set dateappel
     *
     * @param \DateTime $dateappel
     * @return Appels
     */
    public function setDateappel($dateappel)
    {
        $this->dateappel = $dateappel;

        return $this;
    }

    /**
     * Get dateappel
     *
     * @return \DateTime 
     */
    public function getDateappel()
    {
        return $this->dateappel;
    }

    /**
     * Set nomcorresp
     *
     * @param string $nomcorresp
     * @return Appels
     */
    public function setNomcorresp($nomcorresp)
    {
        $this->nomcorresp = $nomcorresp;

        return $this;
    }

    /**
     * Get nomcorresp
     *
     * @return string 
     */
    public function getNomcorresp()
    {
        return $this->nomcorresp;
    }

    /**
     * Set telcorresp
     *
     * @param integer $telcorresp
     * @return Appels
     */
    public function setTelcorresp($telcorresp)
    {
        $this->telcorresp = $telcorresp;

        return $this;
    }

    /**
     * Get telcorresp
     *
     * @return integer 
     */
    public function getTelcorresp()
    {
        return $this->telcorresp;
    }

    /**
     * Set titreappel
     *
     * @param string $titreappel
     * @return Appels
     */
    public function setTitreappel($titreappel)
    {
        $this->titreappel = $titreappel;

        return $this;
    }

    /**
     * Get titreappel
     *
     * @return string 
     */
    public function getTitreappel()
    {
        return $this->titreappel;
    }

    /**
     * Set raisonappel
     *
     * @param string $raisonappel
     * @return Appels
     */
    public function setRaisonappel($raisonappel)
    {
        $this->raisonappel = $raisonappel;

        return $this;
    }

    /**
     * Get raisonappel
     *
     * @return string 
     */
    public function getRaisonappel()
    {
        return $this->raisonappel;
    }

    /**
     * Set solution
     *
     * @param string $solution
     * @return Appels
     */
    public function setSolution($solution)
    {
        $this->solution = $solution;

        return $this;
    }

    /**
     * Get solution
     *
     * @return string 
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * Set temps
     *
     * @param integer $temps
     * @return Appels
     */
    public function setTemps($temps)
    {
        $this->temps = $temps;

        return $this;
    }

    /**
     * Get temps
     *
     * @return integer 
     */
    public function getTemps()
    {
        return $this->temps;
    }
    
    public function getClient() {
        return $this->client;
    }
    
    public function getClientId() {
        return $this->client->getId();
    }

    public function setClient(\obdo\KuchiKomiRESTBundle\Entity\Clients $client) {
        $this->client = $client;
    }
    
    public function getTypeappel() {
        return $this->typeappel;
    }

    public function getTypeappelId() {
        return $this->typeappel->getId();
    }
    
    public function setTypeappel(\obdo\KuchiKomiRESTBundle\Entity\TypeAppel $typeappel) {
        $this->typeappel = $typeappel;
    }


}
