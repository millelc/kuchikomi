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

		// KuchiKomi de bienvenue
		$welcome = new KuchiKomi();
		$welcome->setKuchi($this->getReference('news'));
		$welcome->setTitle('Bienvenue !');
		$welcome->setDetails("Toute l'équipe CityKomi est heureuse de vous accueillir comme nouveau membre !");
		$welcome->setTimestampEnd($welcome->getTimestampEnd()->add(new \DateInterval('P5Y')));
		$this->addReference('welcome', $welcome);
		$manager->persist($welcome);
                $manager->flush();
                $AclManager->addAcl($welcome, $this->getReference('SuperAdmin'));
                
                // KuchiKomi de ToBeDeleted
		$kk1 = new KuchiKomi();
		$kk1->setKuchi($this->getReference('toBeDeleted1'));
		$kk1->setTitle('KuchiKomi 1 !');
		$kk1->setDetails("Mon premier kuchikomi !");
		$kk1->setTimestampEnd($kk1->getTimestampEnd()->add(new \DateInterval('P5Y')));
		$this->addReference('kk1', $kk1);
		$manager->persist($kk1);
                $manager->flush();
                $AclManager->addAcl($kk1, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($kk1, $this->getReference('KuchiAdmin')); 
                
                $kk2 = new KuchiKomi();
		$kk2->setKuchi($this->getReference('eva'));
		$kk2->setTitle("Eva s'exprime");
		$kk2->setDetails("Mon premier kuchikomi !");
		$kk2->setTimestampEnd($kk2->getTimestampEnd()->add(new \DateInterval('P5Y')));
		$this->addReference('kk2', $kk2);
		$manager->persist($kk2);
                $manager->flush();
                $AclManager->addAcl($kk2, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($kk2, $this->getReference('KuchiAdmin'));
		
                $kk3 = new KuchiKomi();
		$kk3->setKuchi($this->getReference('kuchiRef_P_DeleteKuchiKomiAction_1'));
		$kk3->setTitle("Le KuchiKomi qu'on supprime");
		$kk3->setDetails("Mon kuchikomi raté !");
		$kk3->setTimestampEnd($kk3->getTimestampEnd()->add(new \DateInterval('P5Y')));
		$this->addReference('kk3', $kk3);
		$manager->persist($kk3);
                $manager->flush();
                $AclManager->addAcl($kk3, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($kk3, $this->getReference('KuchiAdmin'));
			
	}
        
//        private function createKuchiKomi($kuchi,){
//            
//        }
}