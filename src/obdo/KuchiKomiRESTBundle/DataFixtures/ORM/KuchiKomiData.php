<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;

class KuchiKomiData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		return 4;
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
		$AclManager = $this->container->get('obdo_services.AclManager');
		$manager->getConnection()->exec("ALTER TABLE KuchiKomi AUTO_INCREMENT = 1;");
                
                		

		/****************************************************/
                $this->createKuchiKomi($manager, $AclManager, "Welcome", "kuchiRef_News", "Bienvenue !", "Toute l'équipe CityKomi est heureuse de vous accueillir comme nouveau membre !");
                $this->createKuchiKomi($manager, $AclManager, 'kk3', 'kuchiRef_DeleteKuchiKomiAction_Kuchi', "Le KuchiKomi qu'on supprime", "Mon kuchikomi raté !");
                $this->createKuchiKomi($manager, $AclManager, 'kk2', 'kuchiRef_AuthenticateControllerTest_Kuchi', "Eva s'exprime", "Mon premier kuchikomi !");
	}
        
        private function createKuchiKomi($manager, $AclManager, $kuchikomiRef, $kuchiRef, $Title, $Details)
        {
            $newKuchikomi = new KuchiKomi();
            $newKuchikomi->setKuchi($this->getReference($kuchiRef));
            $newKuchikomi->setTitle($Title);
            $newKuchikomi->setDetails($Details);
            $newKuchikomi->setTimestampEnd($newKuchikomi->getTimestampEnd()->add(new \DateInterval('P5Y')));
            $this->addReference($kuchikomiRef, $newKuchikomi);
            $manager->persist($newKuchikomi);
            $manager->flush();
            $AclManager->addAcl($newKuchikomi, $this->getReference('SuperAdmin'));
        }
}