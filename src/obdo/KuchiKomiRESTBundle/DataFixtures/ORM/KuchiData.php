<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\Kuchi;

class KuchiData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		return 2;
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
		$Password = $this->container->get('obdo_services.Password');
		
		$manager->getConnection()->exec("ALTER TABLE Kuchi AUTO_INCREMENT = 1;");
		
		// Kuchi
		$kuchi1 = new Kuchi();
		$kuchi1->setName('Mairie');
		$kuchi1->setKuchiGroup($this->getReference('kuchiGroup1'));
		$kuchi1->setPassword($Password->generateHash('essai'));
		$kuchi1->setAddress($this->getReference('address1'));
		$this->addReference('kuchi1', $kuchi1);
		$manager->persist($kuchi1);
		
		$kuchi2 = new Kuchi();
		$kuchi2->setName('Médiathèque');
		$kuchi2->setKuchiGroup($this->getReference('kuchiGroup1'));
		$kuchi2->setPassword($Password->generateHash('essai'));
		$kuchi2->setAddress($this->getReference('address2'));
		$this->addReference('kuchi2', $kuchi2);
		$manager->persist($kuchi2);
		
// 		$kuchi3 = new Kuchi();
// 		$kuchi3->setName('Kuchi supprimé');
// 		$kuchi3->setKuchiGroup($kuchiGroup1);
// 		$kuchi3->setPassword('essai');
// 		$kuchi3->setAddress($this->getReference('address3'));
// 		$kuchi3->setActive(false);
//		$this->addReference('kuchi3', $kuchi3);
// 		$manager->persist($kuchi3);
		
		$manager->flush();	
	}
}