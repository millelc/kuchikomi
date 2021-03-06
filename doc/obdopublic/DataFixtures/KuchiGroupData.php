<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\KuchiGroup;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class KuchiGroupData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		$manager->getConnection()->exec("ALTER TABLE KuchiGroup AUTO_INCREMENT = 1;");
		$AclManager = $this->container->get('obdo_services.AclManager');
                		
		$this->createKuchiGroup($manager, $AclManager, "CityKomi");
                
//		// ob-do Group
//		$obdoGroup = new KuchiGroup();
//		$obdoGroup->setName("ob'do");
//                $obdoGroup->addUser($this->getReference('SuperAdmin'));
//                $obdoGroup->addUser($this->getReference('Admin'));
//		$this->addReference('obdoGroup', $obdoGroup);
//		$manager->persist($obdoGroup);
//		$manager->flush();
//		$obdoGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $obdoGroup->getId() . "/logo.jpg" );
//		$manager->persist($obdoGroup);
//		$manager->flush();
//                // ACL
//                $AclManager->addAcl($obdoGroup, $this->getReference('SuperAdmin'));
//                $AclManager->addAcl($obdoGroup, $this->getReference('Admin'));              
//
//                // FB Group
//		$FBGroup = new KuchiGroup();
//		$FBGroup->setName("Feuguerolles-Bully");
//                $FBGroup->addUser($this->getReference('SuperAdmin'));
//                $FBGroup->addUser($this->getReference('Admin'));
//		$this->addReference('fb', $FBGroup);
//		$manager->persist($FBGroup);
//		$manager->flush();
//		$FBGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $FBGroup->getId() . "/logo_groupe.png" );
//		$manager->persist($FBGroup);
//		$manager->flush();
//                // ACL
//                $AclManager->addAcl($FBGroup, $this->getReference('SuperAdmin'));
//                $AclManager->addAcl($FBGroup, $this->getReference('Admin'));
//                
//		// Lycee Group
//		$lyceeGroup = new KuchiGroup();
//		$lyceeGroup->setName("Mon Lycée");
//                $lyceeGroup->addUser($this->getReference('SuperAdmin'));
//                $lyceeGroup->addUser($this->getReference('Admin'));
//		$this->addReference('lyceeGroup', $lyceeGroup);
//		$manager->persist($lyceeGroup);
//		$manager->flush();
//		$lyceeGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $lyceeGroup->getId() . "/logo_lycee.png" );
//		$manager->persist($lyceeGroup);
//		$manager->flush();
//                // ACL
//                $AclManager->addAcl($lyceeGroup, $this->getReference('SuperAdmin'));
//                $AclManager->addAcl($lyceeGroup, $this->getReference('Admin')); 
//                
//                // ToBeDeleted Group
//		$toBeDeletedGroup = new KuchiGroup();
//		$toBeDeletedGroup->setName("To Be Deleted");
//                $toBeDeletedGroup->addUser($this->getReference('SuperAdmin'));
//                $toBeDeletedGroup->addUser($this->getReference('Admin'));
//                $toBeDeletedGroup->addUser($this->getReference('GroupAdmin'));
//		$this->addReference('toBeDeletedGroup', $toBeDeletedGroup);
//		$manager->persist($toBeDeletedGroup);
//		$manager->flush();
//		$toBeDeletedGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $toBeDeletedGroup->getId() . "/logo_lycee.png" );
//		$manager->persist($toBeDeletedGroup);
//		$manager->flush();
//                // ACL
//                $AclManager->addAcl($toBeDeletedGroup, $this->getReference('SuperAdmin'));
//                $AclManager->addAcl($toBeDeletedGroup, $this->getReference('Admin'));
//                $AclManager->addAcl($toBeDeletedGroup, $this->getReference('GroupAdmin')); 
//                
//                /****************************************************/
//
////		$testGroup = new KuchiGroup();
////		$testGroup->setName("test group");
////                $testGroup->addUser($this->getReference('SuperAdmin'));
////                $testGroup->addUser($this->getReference('Admin'));
////                $testGroup->addUser($this->getReference('GroupAdmin'));
////		$this->addReference('Group_test', $testGroup);
////		$manager->persist($testGroup);
////		$manager->flush();
////		$testGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $testGroup->getId() . "/logo_lycee.png" );
////		$manager->persist($testGroup);
////		$manager->flush();
////                // ACL
////                $AclManager->addAcl($testGroup, $this->getReference('SuperAdmin'));
////                $AclManager->addAcl($testGroup, $this->getReference('Admin'));
////                $AclManager->addAcl($testGroup, $this->getReference('GroupAdmin')); 
//                
//                //*********************************************************************/
//                
//
//                $this->createKuchiGroup($manager, $AclManager, "CityKomi");
//		$this->createKuchiGroup($manager, $AclManager, "Group_test");
//                $this->createKuchiGroup($manager, $AclManager, "P_PostSubscriptionGroupAction_1");
//                $this->createKuchiGroup($manager, $AclManager, "P_PostSubscriptionGroupAction_2");
//                $this->createKuchiGroup($manager, $AclManager, "P_PostSubscriptionGroupAction_3");
//                $this->createKuchiGroup($manager, $AclManager, "P_PostSubscriptionGroupAction_4");
//                $this->createKuchiGroup($manager, $AclManager, "P_PostSubscriptionGroupAction_5");
//                $this->createKuchiGroup($manager, $AclManager, "P_PostSubscriptionGroupAction_6");
//                $this->createKuchiGroup($manager, $AclManager, "N_PostSubscriptionGroupAction_1");
//                $this->createKuchiGroup($manager, $AclManager, "N_PostSubscriptionGroupAction_4", false);
//                $this->createKuchiGroup($manager, $AclManager, "N_PostSubscriptionGroupAction_5");
//                $this->createKuchiGroup($manager, $AclManager, "P_DeleteSubscriptionGroupAction_1");
//                $this->createKuchiGroup($manager, $AclManager, "P_DeleteSubscriptionGroupAction_2");
//                $this->createKuchiGroup($manager, $AclManager, "P_DeleteSubscriptionGroupAction_3");
//                $this->createKuchiGroup($manager, $AclManager, "P_DeleteSubscriptionGroupAction_4");
//                $this->createKuchiGroup($manager, $AclManager, "N_DeleteSubscriptionGroupAction_1");
//                $this->createKuchiGroup($manager, $AclManager, "N_DeleteSubscriptionGroupAction_3");
//                $this->createKuchiGroup($manager, $AclManager, "N_DeleteSubscriptionGroupAction_4");
//                $this->createKuchiGroup($manager, $AclManager, "N_DeleteSubscriptionGroupAction_5");
//                $this->createKuchiGroup($manager, $AclManager, "N_DeleteSubscriptionGroupAction_6");
//                $this->createKuchiGroup($manager, $AclManager, "N_DeleteSubscriptionGroupAction_7");
//                $this->createKuchiGroup($manager, $AclManager, "N_DeleteSubscriptionGroupAction_8");
//                $this->createKuchiGroup($manager, $AclManager, "N_DeleteSubscriptionGroupAction_9");
//                $this->createKuchiGroup($manager, $AclManager, "Group_P_PostKuchiKomiAction_1");//, "User_test_PostKuchiKomiAction_1", 'Admin');
        }
        
        private function createKuchiGroup($manager, $AclManager, $name, $active=true)
        {
            $newGroup = new KuchiGroup();
            $newGroup->setName($name);
            $newGroup->setActive($active);
            $newGroup->addUser($this->getReference('root'));
            //$newGroup->addUser($this->getReference('Admin'));
            //$newGroup->addUser($this->getReference('GroupAdmin'));
            $this->addReference($name, $newGroup);
            $manager->persist($newGroup);
            $manager->flush();
            $newGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $newGroup->getId() . "/logo_lycee.png" );
            $manager->persist($newGroup);
            $manager->flush();
            // ACL
            $AclManager->addAcl($newGroup, $this->getReference('root'));
            //$AclManager->addAcl($newGroup, $this->getReference('Admin'));
            //$AclManager->addAcl($newGroup, $this->getReference('GroupAdmin'));
        }
        
//    private  function createKuchiGroup($manager,$AclManager,$name,$refUser,$refUserAcl,$active=true){
//        $kuchigroup = new KuchiGroup();
//        $kuchigroup->setName($name);
//        $kuchigroup->setActive($active);
//        $kuchigroup->addUser($this->getReference($refUser));
//        $this->addReference($name,$kuchigroup);
//        $manager->flush();
//        $kuchigroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $kuchigroup->getId() . "/logo_lycee.png" );
//        $manager->persist($kuchigroup);
//        $manager->flush();
//        $AclManager->addAcl($kuchigroup,  $this->getReference($refUserAcl));
//    }
}