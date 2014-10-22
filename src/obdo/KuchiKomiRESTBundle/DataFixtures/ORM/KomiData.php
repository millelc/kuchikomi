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
		$komi1->setRandomId('ac81d6f9cb600d38');
		$komi1->setOsType(0);
		$komi1->setApplicationVersion( '2.0.0' );
		$komi1->setGcmRegId('sdfsdgrstyhrffsdggh');
		$this->addReference('komi1', $komi1);
		$manager->persist($komi1);
		$manager->flush();	
                $AclManager->addAcl($komi1, $this->getReference('SuperAdmin'));
                
                // new Komi
		$komi2 = new Komi();
		$komi2->setRandomId('cb600d38ac81d6f9');
		$komi2->setOsType(1);
		$komi2->setApplicationVersion( '2.0.0' );
		$komi2->setGcmRegId('sdfsdgrstyhrffsdggh');
		$this->addReference('komi2', $komi2);
		$manager->persist($komi2);
		$manager->flush();	
                $AclManager->addAcl($komi2, $this->getReference('SuperAdmin'));
	
                $komi3 = new Komi();
		$komi3->setRandomId('cb612345ac81d6f8');
		$komi3->setOsType(1);
		$komi3->setApplicationVersion( '2.0.0' );
		$komi3->setGcmRegId('hujtioeplzmapcjitro');
		$this->addReference('komi3', $komi3);
		$manager->persist($komi3);
		$manager->flush();	
                $AclManager->addAcl($komi3, $this->getReference('SuperAdmin'));
        }
        
}