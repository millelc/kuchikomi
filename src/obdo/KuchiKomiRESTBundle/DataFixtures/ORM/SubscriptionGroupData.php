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
                
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_3_Android_1", "P_PostSubscriptionGroupAction_3", SubscriptionGroup::TYPE_NFC);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_3_Android_2", "P_PostSubscriptionGroupAction_3", SubscriptionGroup::TYPE_QRCode);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_3_Android_3", "P_PostSubscriptionGroupAction_3", SubscriptionGroup::TYPE_WEB);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_3_Android_4", "P_PostSubscriptionGroupAction_3", SubscriptionGroup::TYPE_WEB);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_3_iOS_1", "P_PostSubscriptionGroupAction_3", SubscriptionGroup::TYPE_NFC);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_3_iOS_2", "P_PostSubscriptionGroupAction_3", SubscriptionGroup::TYPE_QRCode);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_3_iOS_3", "P_PostSubscriptionGroupAction_3", SubscriptionGroup::TYPE_WEB);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_3_iOS_4", "P_PostSubscriptionGroupAction_3", SubscriptionGroup::TYPE_WEB);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_4_Android_1", "P_PostSubscriptionGroupAction_4", SubscriptionGroup::TYPE_NFC, false);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_4_Android_2", "P_PostSubscriptionGroupAction_4", SubscriptionGroup::TYPE_QRCode, false);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_4_Android_3", "P_PostSubscriptionGroupAction_4", SubscriptionGroup::TYPE_WEB, false);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_4_Android_4", "P_PostSubscriptionGroupAction_4", SubscriptionGroup::TYPE_WEB, false);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_4_iOS_1", "P_PostSubscriptionGroupAction_4", SubscriptionGroup::TYPE_NFC, false);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_4_iOS_2", "P_PostSubscriptionGroupAction_4", SubscriptionGroup::TYPE_QRCode, false);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_4_iOS_3", "P_PostSubscriptionGroupAction_4", SubscriptionGroup::TYPE_WEB, false);
                $this->createSubscriptionGroup($manager, "P_PostSubscriptionGroupAction_4_iOS_4", "P_PostSubscriptionGroupAction_4", SubscriptionGroup::TYPE_WEB, false);
                
		$manager->flush();	
	}
        
        private function createSubscriptionGroup($manager, $komiRef, $kuchiGroupRef, $type, $active=true)
        {
            $newSubscriptionGroup = new SubscriptionGroup();
            $newSubscriptionGroup->setKomi($this->getReference($komiRef));
            $newSubscriptionGroup->setKuchiGroup($this->getReference($kuchiGroupRef));
            $newSubscriptionGroup->setType($type);
            $newSubscriptionGroup->setActive($active);
            $manager->persist($newSubscriptionGroup);
        }
}