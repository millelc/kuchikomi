<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\Komi;

class KomiData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		$AclManager = $this->container->get('obdo_services.AclManager');
		$manager->getConnection()->exec("ALTER TABLE Komi AUTO_INCREMENT = 1;");
		
		// new Komi
		$komi1 = new Komi();
		$komi1->setRandomId('Nicolas');
		$komi1->setOsType(0);
		$komi1->setApplicationVersion( '2.0.0' );
		$komi1->setGcmRegId('sdfsdgrstyhrffsdggh');
		$this->addReference('komi1', $komi1);
		$manager->persist($komi1);
		$manager->flush();	
                $AclManager->addAcl($komi1, $this->getReference('SuperAdmin'));
	}
}