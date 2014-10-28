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
                
                /****************************************************/
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_1_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_1_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_1_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_1_Android_4", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_1_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_1_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_1_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_1_iOS_4", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_2_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_2_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_2_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_2_Android_4", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_2_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_2_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_2_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionAction_2_iOS_4", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_2_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_2_IOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_2_Windows", Komi::OS_TYPE_WINDOWS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_3_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro", false);
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_3_IOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro", false);
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_3_Windows", Komi::OS_TYPE_WINDOWS, "2.0.0", "hujtioeplzmapcjitro", false);
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_4_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_4_IOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_4_Windows", Komi::OS_TYPE_WINDOWS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_5_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_5_IOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_5_Windows", Komi::OS_TYPE_WINDOWS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_6_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_6_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_6_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_6_Android_4", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_6_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_6_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_6_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionAction_6_iOS_4", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionAction_1_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionAction_1_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionAction_1_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionAction_1_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionAction_1_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionAction_1_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_2_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_2_IOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_2_Windows", Komi::OS_TYPE_WINDOWS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_3_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_3_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_3_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_3_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_3_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_3_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_4_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_4_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_4_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_4_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_4_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionAction_4_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_1_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_1_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_1_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_1_Android_4", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_1_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_1_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_1_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_1_iOS_4", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_2_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_2_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_2_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_2_Android_4", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_2_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_2_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_2_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_2_iOS_4", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_3_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_3_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_3_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_3_Android_4", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_3_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_3_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_3_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_3_iOS_4", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_4_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_4_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_4_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_4_Android_4", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_4_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_4_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_4_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_4_iOS_4", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_5_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_5_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_5_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_5_Android_4", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_5_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_5_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_5_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_5_iOS_4", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_6_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_6_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_6_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_6_Android_4", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_6_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_6_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_6_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_PostSubscriptionGroupAction_6_iOS_4", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_2_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_2_IOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_2_Windows", Komi::OS_TYPE_WINDOWS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_3_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro", false);
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_3_IOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro", false);
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_3_Windows", Komi::OS_TYPE_WINDOWS, "2.0.0", "hujtioeplzmapcjitro", false);
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_4_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_4_IOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_4_Windows", Komi::OS_TYPE_WINDOWS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_5_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_5_IOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_PostSubscriptionGroupAction_5_Windows", Komi::OS_TYPE_WINDOWS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_1_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_1_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_1_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_1_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_1_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_1_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_1_Windows_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_1_Windows_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_1_Windows_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_2_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_2_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_2_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_2_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_2_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_2_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_2_Windows_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_2_Windows_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_2_Windows_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_3_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_3_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_3_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_3_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_3_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_3_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_3_Windows_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_3_Windows_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_3_Windows_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_4_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_4_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_4_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_4_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_4_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_4_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_4_Windows_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_4_Windows_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "P_DeleteSubscriptionGroupAction_4_Windows_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_2_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_2_IOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_2_Windows", Komi::OS_TYPE_WINDOWS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_3_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_3_IOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_3_Windows", Komi::OS_TYPE_WINDOWS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_4_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_4_iOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_4_Windows", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_5_Android", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_5_iOS", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_5_Windows", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_6_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_6_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_6_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_6_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_6_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_6_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_6_Windows_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_6_Windows_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_6_Windows_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_7_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_7_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_7_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_7_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_7_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_7_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_7_Windows_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_7_Windows_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_7_Windows_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_8_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_8_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_8_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_8_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_8_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_8_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_8_Windows_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_8_Windows_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_8_Windows_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_9_Android_1", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_9_Android_2", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_9_Android_3", Komi::OS_TYPE_ANDROID, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_9_iOS_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_9_iOS_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_9_iOS_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_9_Windows_1", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_9_Windows_2", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                $this->createKomi($manager, $AclManager, "N_DeleteSubscriptionGroupAction_9_Windows_3", Komi::OS_TYPE_IOS, "2.0.0", "hujtioeplzmapcjitro");
                
        }
        
        private function createKomi($manager, $AclManager, $randomId, $osType, $applicationVersion, $gcmRegId, $active=true)
        {
            $komi_test= new Komi();
            $komi_test->setRandomId($randomId);
            $komi_test->setOsType($osType);
            $komi_test->setApplicationVersion($applicationVersion);
            $komi_test->setGcmRegId($gcmRegId);
            $komi_test->setActive($active);
            $this->addReference($randomId, $komi_test);
            $manager->persist($komi_test);
            $manager->flush();	
            $AclManager->addAcl($komi_test, $this->getReference('SuperAdmin'));
        }
        
}