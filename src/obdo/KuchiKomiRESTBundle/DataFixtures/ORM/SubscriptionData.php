<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\Subscription;

class SubscriptionData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		
		$manager->getConnection()->exec("ALTER TABLE Subscription AUTO_INCREMENT = 1;");
		
		// subscription
		$subscription1 = new Subscription();
		$subscription1->setKomi($this->getReference('komi1'));
		$subscription1->setKuchi($this->getReference('kuchi1'));
		$subscription1->setType(0);
		$this->addReference('subscription1', $subscription1);
		$manager->persist($subscription1);
		
// 		$subscription2 = new Subscription();
// 		$subscription2->setKomi($this->getReference('komi1'));
// 		$subscription2->setKuchi($this->getReference('kuchi3'));
// 		$subscription2->setType(0);
//		$this->addReference('subscription2', $subscription2);
// 		$manager->persist($subscription2);
		
		$manager->flush();	
	}
}