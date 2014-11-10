<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\Kuchi;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class KuchiData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		return 3;
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
		$Password = $this->container->get('obdo_services.Password');
		
		$manager->getConnection()->exec("ALTER TABLE Kuchi AUTO_INCREMENT = 1;");
		$AclManager = $this->container->get('obdo_services.AclManager');
                
  		$this->createKuchi($manager, $AclManager, $Password, "News", "00 00 00 00 00", "news@citykomi.com", "www.citykomi.com", "CityKomi", "News", "address_news", true, true);
                
//		$this->createKuchi($manager, $AclManager, $Password, 'KuchiControllerTest_Kuchi', '00 00 00 00 10', 'paul.vibert@ob-do.com', 'www.ob-do.com', "Group_test", 'paul', 'addressPaul');
//	
//                $this->createKuchi($manager, $AclManager, $Password, 'KuchiControllerTest_KuchiDeleteSync', '00 00 00 00 10', 'paul.vibert@ob-do.com', "Group_test", 'obdoGroup', 'paul', 'tb1Address');
//                
//		$this->createKuchi($manager, $AclManager, $Password, 'AuthenticateControllerTest_Kuchi', '00 00 00 00 11', 'eva.landon@ob-do.com', 'www.ob-do.com', "Group_test", "eva", 'addressEva');
//                      
//		$this->createKuchi($manager, $AclManager, $Password, 'ControllersTests_Kuchi_Inactif', '00 00 00 00 12', 'maxime.marie@ob-do.com', 'www.ob-do.com', "Group_test", 'maxime', 'addressMaxime',FALSE);
//                
//                $this->createKuchi($manager, $AclManager, $Password, "PostKuchiKomiAction_Kuchi", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_P_PostKuchiKomiAction_1", "PostKuchiKomiAction", "kuchi_test_P_PostKuchiKomiAction_1_address",$user=true);
//                
//                $this->createKuchi($manager, $AclManager, $Password, "DeleteKuchiKomiAction_Kuchi","00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "DeleteKuchiKomiAction", "kuchi_test_P_DeleteKuchiKomiAction_1_address");
//                
//		
//                
//                /****************************************************/
//                $this->createKuchi($manager, $AclManager, $Password, "News", "00 00 00 00 00", "news@citykomi.com", "www.citykomi.com", "CityKomi", "News", "kuchi_test_News_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionAction_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "P_PostSubscriptionAction_1", "kuchi_test_P_PostSubscriptionAction_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionAction_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "P_PostSubscriptionAction_2", "kuchi_test_P_PostSubscriptionAction_2_address");
//                $this->createKuchi($manager, $AclManager, $Password, "N_PostSubscriptionAction_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_PostSubscriptionAction_1", "kuchi_test_N_PostSubscriptionAction_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "N_PostSubscriptionAction_4", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_PostSubscriptionAction_4", "kuchi_test_N_PostSubscriptionAction_4_address", false);
//                $this->createKuchi($manager, $AclManager, $Password, "N_PostSubscriptionAction_5", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_PostSubscriptionAction_5", "kuchi_test_N_PostSubscriptionAction_5_address");
//                $this->createKuchi($manager, $AclManager, $Password, "N_PostSubscriptionAction_6", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_PostSubscriptionAction_6", "kuchi_test_N_PostSubscriptionAction_6_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_DeleteSubscriptionAction_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "P_DeleteSubscriptionAction_1", "kuchi_test_P_DeleteSubscriptionAction_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionAction_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_DeleteSubscriptionAction_1", "kuchi_test_N_DeleteSubscriptionAction_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionAction_3", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_DeleteSubscriptionAction_3", "kuchi_test_N_DeleteSubscriptionAction_3_address");
//                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionAction_4", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_DeleteSubscriptionAction_4", "kuchi_test_N_DeleteSubscriptionAction_4_address");
//
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_2_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_2", "P_PostSubscriptionGroupAction_2_1", "kuchi_test_P_PostSubscriptionGroupAction_2_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_2_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_2", "P_PostSubscriptionGroupAction_2_2", "kuchi_test_P_PostSubscriptionGroupAction_2_2_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_3_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_3", "P_PostSubscriptionGroupAction_3_1", "kuchi_test_P_PostSubscriptionGroupAction_3_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_3_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_3", "P_PostSubscriptionGroupAction_3_2", "kuchi_test_P_PostSubscriptionGroupAction_3_2_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_4_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_4", "P_PostSubscriptionGroupAction_4_1", "kuchi_test_P_PostSubscriptionGroupAction_4_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_4_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_4", "P_PostSubscriptionGroupAction_4_2", "kuchi_test_P_PostSubscriptionGroupAction_4_2_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_5_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_5", "P_PostSubscriptionGroupAction_5_1", "kuchi_test_P_PostSubscriptionGroupAction_5_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_5_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_5", "P_PostSubscriptionGroupAction_5_2", "kuchi_test_P_PostSubscriptionGroupAction_5_2_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_6_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_6", "P_PostSubscriptionGroupAction_6_1", "kuchi_test_P_PostSubscriptionGroupAction_6_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_6_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_6", "P_PostSubscriptionGroupAction_6_2", "kuchi_test_P_PostSubscriptionGroupAction_6_2_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_DeleteSubscriptionGroupAction_3_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_DeleteSubscriptionGroupAction_3", "P_DeleteSubscriptionGroupAction_3_1", "kuchi_test_P_DeleteSubscriptionGroupAction_3_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_DeleteSubscriptionGroupAction_3_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_DeleteSubscriptionGroupAction_3", "P_DeleteSubscriptionGroupAction_3_2", "kuchi_test_P_DeleteSubscriptionGroupAction_3_2_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_DeleteSubscriptionGroupAction_4_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_DeleteSubscriptionGroupAction_4", "P_DeleteSubscriptionGroupAction_4_1", "kuchi_test_P_DeleteSubscriptionGroupAction_4_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "P_DeleteSubscriptionGroupAction_4_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_DeleteSubscriptionGroupAction_4", "P_DeleteSubscriptionGroupAction_4_2", "kuchi_test_P_DeleteSubscriptionGroupAction_4_2_address");
//                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionGroupAction_8_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "N_DeleteSubscriptionGroupAction_8", "N_DeleteSubscriptionGroupAction_8_1", "kuchi_test_N_DeleteSubscriptionGroupAction_8_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionGroupAction_8_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "N_DeleteSubscriptionGroupAction_8", "N_DeleteSubscriptionGroupAction_8_2", "kuchi_test_N_DeleteSubscriptionGroupAction_8_2_address");
//                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionGroupAction_9_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "N_DeleteSubscriptionGroupAction_9", "N_DeleteSubscriptionGroupAction_9_1", "kuchi_test_N_DeleteSubscriptionGroupAction_9_1_address");
//                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionGroupAction_9_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "N_DeleteSubscriptionGroupAction_9", "N_DeleteSubscriptionGroupAction_9_2", "kuchi_test_N_DeleteSubscriptionGroupAction_9_2_address");
//                
//                $this->createKuchi($manager, $AclManager, $Password, "ThanksController_Kuchi", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "kuchi_test_ThanksController", 'tb2Address');
        }
        
        private function createKuchi($manager, $AclManager, $Password, $name, $phoneNumber, $mail, $webSite, $kuchiGroupRef, $password, $addressRef, $active=true, $user=false)
        {
            $kuchi_test = new Kuchi();
            $kuchi_test->setName($name);
            $kuchi_test->setPhoneNumber($phoneNumber);
            $kuchi_test->setMailAddress($mail);
            $kuchi_test->setWebSite($webSite);		
            $kuchi_test->setKuchiGroup($this->getReference($kuchiGroupRef));
            $kuchi_test->setPassword($Password->generateHash($password));
            $kuchi_test->setAddress($this->getReference($addressRef));
            $kuchi_test->setActive($active);
            if($user)
            {
                $kuchi_test->addUser($this->getReference('root'));
            }
            $this->addReference("kuchiRef_".$name, $kuchi_test);
            $manager->persist($kuchi_test);
            $manager->flush();
            $folder = $this->container->getParameter('path_kuchikomi_photo') . $kuchi_test->getId();
            $kuchi_test->setPhotoKuchiKomiLink($folder . "/");
            $folder = $this->container->getParameter('path_kuchi_photo') . $kuchi_test->getId();
            $kuchi_test->setLogoLink($folder . "/logo.jpg");
            $kuchi_test->setPhotoLink($folder . "/photo.jpg");
            $manager->persist($kuchi_test);
            $manager->flush();
            // ACL
            $AclManager->addAcl($kuchi_test, $this->getReference('root'));
            //$AclManager->addAcl($kuchi_test, $this->getReference('Admin'));
            //$AclManager->addAcl($kuchi_test, $this->getReference('GroupAdmin'));
        }
        
}