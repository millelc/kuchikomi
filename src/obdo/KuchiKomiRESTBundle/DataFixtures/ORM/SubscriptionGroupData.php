<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\SubscriptionGroup;

class SubscriptionGroupData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		
		$manager->getConnection()->exec("ALTER TABLE SubscriptionGroup AUTO_INCREMENT = 1;");
                
                $subscriptionGroup1 = new SubscriptionGroup();
                $subscriptionGroup1->setKomi($this->getReference('komi2'));
                $subscriptionGroup1->setKuchiGroup($this->getReference('toBeDeletedGroup'));
                $subscriptionGroup1->setType(1);
                $manager->persist($subscriptionGroup1);
                
                $subscriptionGroup2 = new SubscriptionGroup();
                $subscriptionGroup2->setKomi($this->getReference('komi2'));
                $subscriptionGroup2->setKuchiGroup($this->getReference('lyceeGroup'));
                $subscriptionGroup2->setType(1);
                $subscriptionGroup2->setActive(false);
                $manager->persist($subscriptionGroup2);
		
		$manager->flush();	
	}
}