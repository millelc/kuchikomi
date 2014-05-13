<?php

namespace obdo\KuchiKomiUserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="obdo\KuchiKomiUserBundle\Entity\UserRepository")
 */
class User extends BaseUser {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\KuchiGroup", cascade={"persist"})
     */
    private $kuchigroups;

    /**
     * @ORM\ManyToMany(targetEntity="obdo\KuchiKomiRESTBundle\Entity\Kuchi", cascade={"persist"})
     */
    private $kuchis;

    public function __construct() {
        parent::__construct();
        $this->kuchigroups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->kuchis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add KuchiGroups
     *
     * @param obdo\KuchiKomiRestBundle\Entity\KuchiGroup $kuchigroups
     */
    public function addKuchiGroup(\obdo\KuchiKomiRestBundle\Entity\KuchiGroup $kuchigroup) { // sans « s » !
        // Ici, on utilise l'ArrayCollection vraiment comme un tableau, avec la syntaxe []
        $this->kuchigroups[] = $kuchigroup;
    }

    /**
     * Remove KuchiGroups
     *
     * @param obdo\KuchiKomiRestBundle\Entity\KuchiGroup $kuchigroups
     */
    public function removeKuchiGroup(\Sdz\BlogBundle\Entity\KuchiGroup $kuchigroup) { // sans « s » !
        // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
        $this->kuchigroups->removeElement($kuchigroup);
    }

    /**
     * Get KuchiGroups
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getKuchiGroups() { // Notez le « s », on récupère une liste de KushiGroup ici !
        return $this->kuchigroups;
    }
    
    /**
     * Add Kuchis
     *
     * @param obdo\KuchiKomiRestBundle\Entity\Kuchi $kuchis
     */
    public function addKuchi(\obdo\KuchiKomiRestBundle\Entity\Kuchi $kuchi) { // sans « s » !
        // Ici, on utilise l'ArrayCollection vraiment comme un tableau, avec la syntaxe []
        $this->kuchis[] = $kuchi;
    }

    /**
     * Remove Kuchis
     *
     * @param obdo\KuchiKomiRestBundle\Entity\Kuchi $kuchis
     */
    public function removeKuchi(\Sdz\BlogBundle\Entity\Kuchi $kuchi) { // sans « s » !
        // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
        $this->kuchis->removeElement($kuchi);
    }

    /**
     * Get Kuchis
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getKuchis() { // Notez le « s », on récupère une liste de Kushi ici !
        return $this->kuchis;
    }

}
