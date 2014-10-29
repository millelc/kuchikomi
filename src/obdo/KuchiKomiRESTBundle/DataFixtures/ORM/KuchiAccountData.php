<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\KuchiAccount;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class KuchiAccountData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
            return 3;
    }


    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
				        
        $manager->getConnection()->exec("ALTER TABLE KuchiAccount AUTO_INCREMENT = 1;");
        


      //  $this->createKuchiAccount($manager, $this->getReference('KomiControllerTest_KomiRandomId'), $this->getReference('david'));
 
        $this->createKuchiAccount($manager, $this->getReference('KuchiControllerTest_KomiRandomId'), $this->getReference('kuchiRef_ControllersTests_Kuchi_Inactif'));
        
        $this->createKuchiAccount($manager, $this->getReference('KuchiControllerTest_KomiRandomId'), $this->getReference('kuchiRef_KuchiControllerTest_Kuchi'));
        
        $this->createKuchiAccount($manager, $this->getReference('KuchiControllerTest_KomiRandomId'), $this->getReference('kuchiRef_KuchiControllerTest_KuchiDeleteSync'));
         
        $this->createKuchiAccount($manager, $this->getReference('AuthenticateControllerTest_KomiRandomId'), $this->getReference('kuchiRef_ControllersTests_Kuchi_Inactif'));
        
        $this->createKuchiAccount($manager, $this->getReference('AuthenticateControllerTest_KomiRandomId'), $this->getReference('kuchiRef_AuthenticateControllerTest_Kuchi'));

        //$this->createKuchiAccount($manager, $this->getReference('AuthenticateControllerTest_KomiRandomId'), $this->getReference('kuchiRef_KuchiControllerTest_Kuchi'));
        
        $this->createKuchiAccount($manager, $this->getReference('PostKuchiKomiAction_RandomId'), $this->getReference("kuchiRef_PostKuchiKomiAction_Kuchi"));
        
        $this->createKuchiAccount($manager, $this->getReference('DeleteKuchiKomiAction_RandomId'), $this->getReference("kuchiRef_DeleteKuchiKomiAction_Kuchi"));


    }
    
    private function createKuchiAccount ($manager,$komi,$kuchi)
        {
        $kuchiaccount = new KuchiAccount();
        $kuchiaccount->setKomi($komi);
        $kuchiaccount->setKuchi($kuchi);
        $manager->persist($kuchiaccount);
        $manager->flush();
        
        }

}