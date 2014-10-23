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
                
                $subscription1 = new Subscription();
                $subscription1->setKomi($this->getReference('komi1'));
                $subscription1->setKuchi($this->getReference('david'));

                $manager->persist($subscription1);
                
                $subscription2 = new Subscription();
                $subscription2->setKomi($this->getReference('komi2'));
                $subscription2->setKuchi($this->getReference('nicolas'));
                $subscription2->setType(Subscription::TYPE_NFC);

                $manager->persist($subscription2);
		
                $subscription3 = new Subscription();
                $subscription3->setKomi($this->getReference('komi2'));
                $subscription3->setKuchi($this->getReference('david'));
                $subscription3->setType(Subscription::TYPE_QRCode);

                $manager->persist($subscription3);
                
                $subscription4 = new Subscription();
                $subscription4->setKomi($this->getReference('komi2'));
                $subscription4->setKuchi($this->getReference('julien'));
                $subscription4->setType(3);

                $manager->persist($subscription4);
                
		$manager->flush();	
	}
}