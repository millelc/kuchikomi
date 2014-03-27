<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\Address;

class AddressData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		$manager->getConnection()->exec("ALTER TABLE Address AUTO_INCREMENT = 1;");
		
		// Address
		$address1 = new Address();
		$address1->setAddress1('Rue de Caen');
		$address1->setAddress2('');
		$address1->setAddress3('');
		$address1->setPostalCode('14320');
		$address1->setCity('Feuguerolles-Bully');
		$this->addReference('address1', $address1);
		$manager->persist($address1);
		
		$address2 = new Address();
		$address2->setAddress1('Rue de Maltot');
		$address2->setAddress2('');
		$address2->setAddress3('');
		$address2->setPostalCode('14320');
		$address2->setCity('Feuguerolles-Bully');
		$this->addReference('address2', $address2);
		$manager->persist($address2);
		


		// 		$address3 = new Address();
		// 		$address3->setAddress1('Rue de Maltot');
		// 		$address3->setAddress2('');
		// 		$address3->setAddress3('');
		// 		$address3->setPostalCode('14320');
		// 		$address3->setCity('Feuguerolles-Bully');
		//		$this->addReference('address3', $address3);
		// 		$manager->persist($address3);
		
		$manager->flush();	
	}
}