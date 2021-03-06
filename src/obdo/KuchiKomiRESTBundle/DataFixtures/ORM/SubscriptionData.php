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
//                
//                $subscription1 = new Subscription();
//                $subscription1->setKomi($this->getReference('KomiControllerTest_KomiRandomId'));
//                $subscription1->setKuchi($this->getReference('david'));
//
//                $manager->persist($subscription1);
//                
//                $subscription2 = new Subscription();
//                $subscription2->setKomi($this->getReference('KuchiControllerTest_KomiRandomId'));
//                $subscription2->setKuchi($this->getReference('nicolas'));
//                $subscription2->setType(Subscription::TYPE_NFC);
//
//                $manager->persist($subscription2);
//		
//                $subscription3 = new Subscription();
//                $subscription3->setKomi($this->getReference('KuchiControllerTest_KomiRandomId'));
//                $subscription3->setKuchi($this->getReference('david'));
//                $subscription3->setType(Subscription::TYPE_QRCode);
//
//                $manager->persist($subscription3);
//                
//                $subscription4 = new Subscription();
//                $subscription4->setKomi($this->getReference('KuchiControllerTest_KomiRandomId'));
//                $subscription4->setKuchi($this->getReference('julien'));
//                $subscription4->setType(3);
//
//                $manager->persist($subscription4);
                
                
                /****************************************************/
                $this->createSubscription($manager, "P_PostSubscriptionAction_2_Android_1", "kuchiRef_P_PostSubscriptionAction_2", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "P_PostSubscriptionAction_2_Android_2", "kuchiRef_P_PostSubscriptionAction_2", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "P_PostSubscriptionAction_2_Android_3", "kuchiRef_P_PostSubscriptionAction_2", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "P_PostSubscriptionAction_2_Android_4", "kuchiRef_P_PostSubscriptionAction_2", 123456, false);
                $this->createSubscription($manager, "P_PostSubscriptionAction_2_iOS_1", "kuchiRef_P_PostSubscriptionAction_2", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "P_PostSubscriptionAction_2_iOS_2", "kuchiRef_P_PostSubscriptionAction_2", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "P_PostSubscriptionAction_2_iOS_3", "kuchiRef_P_PostSubscriptionAction_2", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "P_PostSubscriptionAction_2_iOS_4", "kuchiRef_P_PostSubscriptionAction_2", 123456, false);                
                $this->createSubscription($manager, "N_PostSubscriptionAction_6_Android_1", "kuchiRef_N_PostSubscriptionAction_6", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "N_PostSubscriptionAction_6_Android_2", "kuchiRef_N_PostSubscriptionAction_6", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "N_PostSubscriptionAction_6_Android_3", "kuchiRef_N_PostSubscriptionAction_6", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "N_PostSubscriptionAction_6_Android_4", "kuchiRef_N_PostSubscriptionAction_6", 123456);
                $this->createSubscription($manager, "N_PostSubscriptionAction_6_iOS_1", "kuchiRef_N_PostSubscriptionAction_6", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "N_PostSubscriptionAction_6_iOS_2", "kuchiRef_N_PostSubscriptionAction_6", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "N_PostSubscriptionAction_6_iOS_3", "kuchiRef_N_PostSubscriptionAction_6", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "N_PostSubscriptionAction_6_iOS_4", "kuchiRef_N_PostSubscriptionAction_6", 123456);                
                $this->createSubscription($manager, "P_DeleteSubscriptionAction_1_Android_1", "kuchiRef_P_DeleteSubscriptionAction_1", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionAction_1_Android_2", "kuchiRef_P_DeleteSubscriptionAction_1", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionAction_1_Android_3", "kuchiRef_P_DeleteSubscriptionAction_1", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionAction_1_iOS_1", "kuchiRef_P_DeleteSubscriptionAction_1", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionAction_1_iOS_2", "kuchiRef_P_DeleteSubscriptionAction_1", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionAction_1_iOS_3", "kuchiRef_P_DeleteSubscriptionAction_1", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "N_DeleteSubscriptionAction_4_Android_1", "kuchiRef_N_DeleteSubscriptionAction_4", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionAction_4_Android_2", "kuchiRef_N_DeleteSubscriptionAction_4", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionAction_4_Android_3", "kuchiRef_N_DeleteSubscriptionAction_4", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionAction_4_iOS_1", "kuchiRef_N_DeleteSubscriptionAction_4", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionAction_4_iOS_2", "kuchiRef_N_DeleteSubscriptionAction_4", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionAction_4_iOS_3", "kuchiRef_N_DeleteSubscriptionAction_4", Subscription::TYPE_WEB, false);               
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_5_Android_1", "kuchiRef_P_PostSubscriptionGroupAction_5_1", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_5_Android_2", "kuchiRef_P_PostSubscriptionGroupAction_5_2", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_5_Android_3", "kuchiRef_P_PostSubscriptionGroupAction_5_1", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_5_Android_4", "kuchiRef_P_PostSubscriptionGroupAction_5_2", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_5_iOS_1", "kuchiRef_P_PostSubscriptionGroupAction_5_1", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_5_iOS_2", "kuchiRef_P_PostSubscriptionGroupAction_5_2", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_5_iOS_3", "kuchiRef_P_PostSubscriptionGroupAction_5_1", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_5_iOS_4", "kuchiRef_P_PostSubscriptionGroupAction_5_2", Subscription::TYPE_WEB);                
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_6_Android_1", "kuchiRef_P_PostSubscriptionGroupAction_6_1", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_6_Android_2", "kuchiRef_P_PostSubscriptionGroupAction_6_2", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_6_Android_3", "kuchiRef_P_PostSubscriptionGroupAction_6_1", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_6_Android_4", "kuchiRef_P_PostSubscriptionGroupAction_6_2", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_6_iOS_1", "kuchiRef_P_PostSubscriptionGroupAction_6_1", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_6_iOS_2", "kuchiRef_P_PostSubscriptionGroupAction_6_2", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_6_iOS_3", "kuchiRef_P_PostSubscriptionGroupAction_6_1", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "P_PostSubscriptionGroupAction_6_iOS_4", "kuchiRef_P_PostSubscriptionGroupAction_6_2", Subscription::TYPE_WEB, false);                
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Android_1", "kuchiRef_P_DeleteSubscriptionGroupAction_3_1", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Android_1", "kuchiRef_P_DeleteSubscriptionGroupAction_3_2", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Android_2", "kuchiRef_P_DeleteSubscriptionGroupAction_3_1", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Android_2", "kuchiRef_P_DeleteSubscriptionGroupAction_3_2", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Android_3", "kuchiRef_P_DeleteSubscriptionGroupAction_3_1", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Android_3", "kuchiRef_P_DeleteSubscriptionGroupAction_3_2", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_iOS_1", "kuchiRef_P_DeleteSubscriptionGroupAction_3_1", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_iOS_1", "kuchiRef_P_DeleteSubscriptionGroupAction_3_2", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_iOS_2", "kuchiRef_P_DeleteSubscriptionGroupAction_3_1", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_iOS_2", "kuchiRef_P_DeleteSubscriptionGroupAction_3_2", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_iOS_3", "kuchiRef_P_DeleteSubscriptionGroupAction_3_1", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_iOS_3", "kuchiRef_P_DeleteSubscriptionGroupAction_3_2", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Windows_1", "kuchiRef_P_DeleteSubscriptionGroupAction_3_1", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Windows_1", "kuchiRef_P_DeleteSubscriptionGroupAction_3_2", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Windows_2", "kuchiRef_P_DeleteSubscriptionGroupAction_3_1", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Windows_2", "kuchiRef_P_DeleteSubscriptionGroupAction_3_2", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Windows_3", "kuchiRef_P_DeleteSubscriptionGroupAction_3_1", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_3_Windows_3", "kuchiRef_P_DeleteSubscriptionGroupAction_3_2", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Android_1", "kuchiRef_P_DeleteSubscriptionGroupAction_4_1", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Android_1", "kuchiRef_P_DeleteSubscriptionGroupAction_4_2", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Android_2", "kuchiRef_P_DeleteSubscriptionGroupAction_4_1", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Android_2", "kuchiRef_P_DeleteSubscriptionGroupAction_4_2", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Android_3", "kuchiRef_P_DeleteSubscriptionGroupAction_4_1", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Android_3", "kuchiRef_P_DeleteSubscriptionGroupAction_4_2", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_iOS_1", "kuchiRef_P_DeleteSubscriptionGroupAction_4_1", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_iOS_1", "kuchiRef_P_DeleteSubscriptionGroupAction_4_2", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_iOS_2", "kuchiRef_P_DeleteSubscriptionGroupAction_4_1", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_iOS_2", "kuchiRef_P_DeleteSubscriptionGroupAction_4_2", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_iOS_3", "kuchiRef_P_DeleteSubscriptionGroupAction_4_1", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_iOS_3", "kuchiRef_P_DeleteSubscriptionGroupAction_4_2", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Windows_1", "kuchiRef_P_DeleteSubscriptionGroupAction_4_1", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Windows_1", "kuchiRef_P_DeleteSubscriptionGroupAction_4_2", Subscription::TYPE_NFC);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Windows_2", "kuchiRef_P_DeleteSubscriptionGroupAction_4_1", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Windows_2", "kuchiRef_P_DeleteSubscriptionGroupAction_4_2", Subscription::TYPE_QRCode);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Windows_3", "kuchiRef_P_DeleteSubscriptionGroupAction_4_1", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "P_DeleteSubscriptionGroupAction_4_Windows_3", "kuchiRef_P_DeleteSubscriptionGroupAction_4_2", Subscription::TYPE_WEB);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Android_1", "kuchiRef_N_DeleteSubscriptionGroupAction_8_1", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Android_1", "kuchiRef_N_DeleteSubscriptionGroupAction_8_2", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Android_2", "kuchiRef_N_DeleteSubscriptionGroupAction_8_1", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Android_2", "kuchiRef_N_DeleteSubscriptionGroupAction_8_2", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Android_3", "kuchiRef_N_DeleteSubscriptionGroupAction_8_1", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Android_3", "kuchiRef_N_DeleteSubscriptionGroupAction_8_2", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_iOS_1", "kuchiRef_N_DeleteSubscriptionGroupAction_8_1", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_iOS_1", "kuchiRef_N_DeleteSubscriptionGroupAction_8_2", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_iOS_2", "kuchiRef_N_DeleteSubscriptionGroupAction_8_1", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_iOS_2", "kuchiRef_N_DeleteSubscriptionGroupAction_8_2", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_iOS_3", "kuchiRef_N_DeleteSubscriptionGroupAction_8_1", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_iOS_3", "kuchiRef_N_DeleteSubscriptionGroupAction_8_2", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Windows_1", "kuchiRef_N_DeleteSubscriptionGroupAction_8_1", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Windows_1", "kuchiRef_N_DeleteSubscriptionGroupAction_8_2", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Windows_2", "kuchiRef_N_DeleteSubscriptionGroupAction_8_1", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Windows_2", "kuchiRef_N_DeleteSubscriptionGroupAction_8_2", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Windows_3", "kuchiRef_N_DeleteSubscriptionGroupAction_8_1", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_8_Windows_3", "kuchiRef_N_DeleteSubscriptionGroupAction_8_2", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Android_1", "kuchiRef_N_DeleteSubscriptionGroupAction_9_1", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Android_1", "kuchiRef_N_DeleteSubscriptionGroupAction_9_2", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Android_2", "kuchiRef_N_DeleteSubscriptionGroupAction_9_1", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Android_2", "kuchiRef_N_DeleteSubscriptionGroupAction_9_2", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Android_3", "kuchiRef_N_DeleteSubscriptionGroupAction_9_1", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Android_3", "kuchiRef_N_DeleteSubscriptionGroupAction_9_2", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_iOS_1", "kuchiRef_N_DeleteSubscriptionGroupAction_9_1", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_iOS_1", "kuchiRef_N_DeleteSubscriptionGroupAction_9_2", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_iOS_2", "kuchiRef_N_DeleteSubscriptionGroupAction_9_1", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_iOS_2", "kuchiRef_N_DeleteSubscriptionGroupAction_9_2", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_iOS_3", "kuchiRef_N_DeleteSubscriptionGroupAction_9_1", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_iOS_3", "kuchiRef_N_DeleteSubscriptionGroupAction_9_2", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Windows_1", "kuchiRef_N_DeleteSubscriptionGroupAction_9_1", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Windows_1", "kuchiRef_N_DeleteSubscriptionGroupAction_9_2", Subscription::TYPE_NFC, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Windows_2", "kuchiRef_N_DeleteSubscriptionGroupAction_9_1", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Windows_2", "kuchiRef_N_DeleteSubscriptionGroupAction_9_2", Subscription::TYPE_QRCode, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Windows_3", "kuchiRef_N_DeleteSubscriptionGroupAction_9_1", Subscription::TYPE_WEB, false);
                $this->createSubscription($manager, "N_DeleteSubscriptionGroupAction_9_Windows_3", "kuchiRef_N_DeleteSubscriptionGroupAction_9_2", Subscription::TYPE_WEB, false);

                $this->createSubscription($manager, "PostKuchiKomiAction_RandomId_Abonne", "kuchiRef_PostKuchiKomiAction_Kuchi", Subscription::TYPE_QRCode);

		$manager->flush();	
	}
        
        private function createSubscription($manager, $komiRef, $kuchiRef, $type, $active=true)
        {
            $newSubscription = new Subscription();
            $newSubscription->setKomi($this->getReference($komiRef));
            $newSubscription->setKuchi($this->getReference($kuchiRef));
            $newSubscription->setType($type);
            $newSubscription->setActive($active);

            $manager->persist($newSubscription);
        }
}