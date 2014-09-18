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
                		
		// CityKomi Group
		$citykomiGroup = new KuchiGroup();
		$citykomiGroup->setName("CityKomi");
                $citykomiGroup->addUser($this->getReference('SuperAdmin'));
                $citykomiGroup->addUser($this->getReference('Admin'));
                $this->addReference('citykomiGroup', $citykomiGroup);
		$manager->persist($citykomiGroup);
		$manager->flush();
		$citykomiGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $citykomiGroup->getId() . "/logo.jpg" );
		$manager->persist($citykomiGroup);
		$manager->flush();
                //  ACL
                $AclManager->addAcl($citykomiGroup, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($citykomiGroup, $this->getReference('Admin'));
		
		// ob-do Group
		$obdoGroup = new KuchiGroup();
		$obdoGroup->setName("ob'do");
                $obdoGroup->addUser($this->getReference('SuperAdmin'));
                $obdoGroup->addUser($this->getReference('Admin'));
		$this->addReference('obdoGroup', $obdoGroup);
		$manager->persist($obdoGroup);
		$manager->flush();
		$obdoGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $obdoGroup->getId() . "/logo.jpg" );
		$manager->persist($obdoGroup);
		$manager->flush();
                // ACL
                $AclManager->addAcl($obdoGroup, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($obdoGroup, $this->getReference('Admin'));              

                // FB Group
		$FBGroup = new KuchiGroup();
		$FBGroup->setName("Feuguerolles-Bully");
                $FBGroup->addUser($this->getReference('SuperAdmin'));
                $FBGroup->addUser($this->getReference('Admin'));
		$this->addReference('fb', $FBGroup);
		$manager->persist($FBGroup);
		$manager->flush();
		$FBGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $FBGroup->getId() . "/logo_groupe.png" );
		$manager->persist($FBGroup);
		$manager->flush();
                // ACL
                $AclManager->addAcl($FBGroup, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($FBGroup, $this->getReference('Admin'));
                
		// Lycee Group
		$lyceeGroup = new KuchiGroup();
		$lyceeGroup->setName("Mon Lycée");
                $lyceeGroup->addUser($this->getReference('SuperAdmin'));
                $lyceeGroup->addUser($this->getReference('Admin'));
		$this->addReference('lyceeGroup', $lyceeGroup);
		$manager->persist($lyceeGroup);
		$manager->flush();
		$lyceeGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $lyceeGroup->getId() . "/logo_lycee.png" );
		$manager->persist($lyceeGroup);
		$manager->flush();
                // ACL
                $AclManager->addAcl($lyceeGroup, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($lyceeGroup, $this->getReference('Admin')); 
                
                // ToBeDeleted Group
		$toBeDeletedGroup = new KuchiGroup();
		$toBeDeletedGroup->setName("To Be Deleted");
                $toBeDeletedGroup->addUser($this->getReference('SuperAdmin'));
                $toBeDeletedGroup->addUser($this->getReference('Admin'));
                $toBeDeletedGroup->addUser($this->getReference('GroupAdmin'));
		$this->addReference('toBeDeletedGroup', $toBeDeletedGroup);
		$manager->persist($toBeDeletedGroup);
		$manager->flush();
		$toBeDeletedGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $toBeDeletedGroup->getId() . "/logo_lycee.png" );
		$manager->persist($toBeDeletedGroup);
		$manager->flush();
                // ACL
                $AclManager->addAcl($toBeDeletedGroup, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($toBeDeletedGroup, $this->getReference('Admin'));
                $AclManager->addAcl($toBeDeletedGroup, $this->getReference('GroupAdmin')); 
                
               
        }
        
}