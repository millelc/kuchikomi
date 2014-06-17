<?php

namespace obdo\KuchiKomiRESTBundle\Form;


class AppelForm
{
   
    private $dateappel;

    private $nomcorresp;

    private $telcorresp;

    private $titreappel;

    private $raisonappel;

    private $solution;

    private $temps;

    private $client;

    private $typeappel;
    
    private $newtype;
    
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

    public function setClient($client) {
        $this->client = $client;
    }
    
    public function getTypeappel() {
        return $this->typeappel;
    }

    public function setTypeappel($typeappel) {
        $this->typeappel = $typeappel;
    }
    
    public function getNewtype() {
        return $this->newtype;
    }

    public function setNewtype($newtype) {
        $this->newtype = $newtype;
    }


}
