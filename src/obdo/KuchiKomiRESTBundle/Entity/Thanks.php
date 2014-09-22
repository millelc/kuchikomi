<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Thanks
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\ThanksRepository")
 */
class Thanks
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="randomId", type="string", length=255)
     */
    private $komiRandomId;

    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\KuchiKomi", inversedBy="thanks")
    */
    private $kuchikomi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampCreation", type="datetime")
     */
    private $timestampCreation;

    public function __construct()
    {
    	$this->timestampCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
    }
    
    /**
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     * @return Thanks
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
     * Set komi
     *
     * @param 
     * @return Thanks
     */
    public function setKomiRandomId( $randomId )
    {
        $this->komiRandomId = $randomId;

        return $this;
    }

    /**
     * Get komi randomId
     *
     * @return string
     */
    public function getKomiRandomId()
    {
        return $this->komiRandomId;
    }

    /**
     * Set kuchikomi
     *
     * @param \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomi
     * @return Thanks
     */
    public function setKuchiKomi(\obdo\KuchiKomiRESTBundle\Entity\KuchiKomi $kuchikomi)
    {
        $this->kuchikomi = $kuchikomi;

        return $this;
    }

    /**
     * Get kuchikomi
     *
     * @return \obdo\KuchiKomiRESTBundle\Entity\KuchiKomi 
     */
    public function getKuchiKomi()
    {
        return $this->kuchikomi;
    }
}
