<?php

namespace obdo\KuchiKomiRESTBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\Util\SecureRandom;

/**
 * KuchiAccount
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiRESTBundle\Entity\KuchiAccountRepository")
 * 
 * @ExclusionPolicy("all")
 */
class KuchiAccount
{
    const TOKEN_SIZE = 13;
    
    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Komi")
    */
    private $komi;

    /**
    * @ORM\Id
    * @ORM\ManyToOne(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Kuchi")
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
     * @ORM\Column(name="timestampLastSynchro", type="datetime")
     */
    private $timestampLastSynchro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestampLastSynchroSaved", type="datetime")
     */
    private $timestampLastSynchroSaved;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=26)
     * @Expose
     * @Groups({"Authenticate"})
     */
    private $token;


        public function __construct()
    {
        $this->timestampCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->resetTimestampLastSynchro();
        $this->generateToken();
    }

    public function resetTimestampLastSynchro()
    {
    	$this->timestampLastSynchro = new \DateTime('2014-01-01 00:00:00.000000', new \DateTimeZone('Europe/Paris'));
        $this->timestampLastSynchroSaved = new \DateTime('2014-01-01 00:00:00.000000', new \DateTimeZone('Europe/Paris'));
    }

    /**
     * Set token
     *
     * @param string $token
     * @return KuchiAccount
     */
    public function generateToken()
    {
        $generator = new SecureRandom();
        $this->token = bin2hex($generator->nextBytes( self::TOKEN_SIZE ));

        return $this;
    }
    
    /**
     * set kuchi
     *
     * @return kuchiAccount 
     */
    public function setKuchi($kuchi)
    {
        $this->kuchi = $kuchi;
        return $this;
    }
    
    /**
     * Get kuchi
     *
     * @return kuchi 
     */
    public function getKuchi()
    {
        return $this->kuchi;
    }
    
    /**
     * set komi
     *
     * @return kuchiAccount 
     */
    public function setKomi($komi)
    {
        $this->komi = $komi;
        return $this;
    }
    
    /**
     * Get komi
     *
     * @return komi 
     */
    public function getKomi()
    {
        return $this->komi;
    }

    /**
     * Set timestampCreation
     *
     * @param \DateTime $timestampCreation
     * @return KuchiAccount
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
     * Set timestampLastSynchro
     *
     * @param \DateTime $timestampLastSynchro
     * @return KuchiAccount
     */
    public function setTimestampLastSynchro($timestampLastSynchro)
    {
        $this->timestampLastSynchro = $timestampLastSynchro;

        return $this;
    }
    
    /**
     * Set timestampLastSynchro to current
     *
     * @return Komi
     */
    public function setCurrentTimestampLastSynchroSaved()
    {
    	$this->timestampLastSynchroSaved = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
    
    	return $this;
    }

    /**
     * Validate the last synchro date saved
     *
     * @return Komi
     */
    public function validateLastSynchro()
    {
        $this->timestampLastSynchro = $this->timestampLastSynchroSaved;
    }
    
    /**
     * Get timestampLastSynchro
     *
     * @return \DateTime 
     */
    public function getTimestampLastSynchro()
    {
        return $this->timestampLastSynchro;
    }
    
    /**
     * Get timestampLastSynchroSaved
     *
     * @return \DateTime 
     */
    public function getTimestampLastSynchroSaved() 
    {
        return $this->timestampLastSynchroSaved;
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
    


}
