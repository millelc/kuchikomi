<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\KuchiGroup;

class KuchiGroupData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		return 1;
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
		$manager->getConnection()->exec("ALTER TABLE KuchiGroup AUTO_INCREMENT = 1;");
		
		// Feuguerolles-Bully Group
		$kuchiGroup1 = new KuchiGroup();
		$kuchiGroup1->setName('Feuguerolles-Bully');
		$this->addReference('kuchiGroup1', $kuchiGroup1);
		$manager->persist($kuchiGroup1);
		$manager->flush();
		$kuchiGroup1->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $kuchiGroup1->getId() . "/logo.jpg" );
		$manager->persist($kuchiGroup1);
		$manager->flush();
		
		// ob-do Group
		$obdoGroup = new KuchiGroup();
		$obdoGroup->setName("ob'do");
		$this->addReference('obdoGroup', $obdoGroup);
		$manager->persist($obdoGroup);
		$manager->flush();
		$obdoGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $obdoGroup->getId() . "/logo.jpg" );
		$manager->persist($obdoGroup);
		$manager->flush();	
		
		// CityKomi Group
		$citykomiGroup = new KuchiGroup();
		$citykomiGroup->setName("CityKomi");
		$this->addReference('citykomiGroup', $citykomiGroup);
		$manager->persist($citykomiGroup);
		$manager->flush();
		$citykomiGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $citykomiGroup->getId() . "/logo.jpg" );
		$manager->persist($citykomiGroup);
		$manager->flush();
	}
}