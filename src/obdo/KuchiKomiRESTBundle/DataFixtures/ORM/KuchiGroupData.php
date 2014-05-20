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
		
                		
		// CityKomi Group
		$citykomiGroup = new KuchiGroup();
		$citykomiGroup->setName("CityKomi");
                $citykomiGroup->addUser($this->getReference('SuperAdmin'));
                $citykomiGroup->addUser($this->getReference('Admin'));
                $citykomiGroup->addUser($this->getReference('GroupAdmin'));
                $this->addReference('citykomiGroup', $citykomiGroup);
		$manager->persist($citykomiGroup);
		$manager->flush();
		$citykomiGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $citykomiGroup->getId() . "/logo.jpg" );
		$manager->persist($citykomiGroup);
		$manager->flush();
                // create the ACL
                $aclProvider = $this->container->get('security.acl.provider');
                $objectIdentity = ObjectIdentity::fromDomainObject($citykomiGroup);
                $acl = $aclProvider->createAcl($objectIdentity);
                //insert useracl
                $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('SuperAdmin'));
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);
                //insert useracl
                $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('Admin'));
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);
                //insert useracl
                $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('GroupAdmin'));
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);
                
		
		
		// ob-do Group
		$obdoGroup = new KuchiGroup();
		$obdoGroup->setName("ob'do");
                $obdoGroup->addUser($this->getReference('SuperAdmin'));
                $obdoGroup->addUser($this->getReference('Admin'));
                $obdoGroup->addUser($this->getReference('GroupAdmin'));
		$this->addReference('obdoGroup', $obdoGroup);
		$manager->persist($obdoGroup);
		$manager->flush();
		$obdoGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $obdoGroup->getId() . "/logo.jpg" );
		$manager->persist($obdoGroup);
		$manager->flush();
                // create the ACL
                $aclProvider = $this->container->get('security.acl.provider');
                $objectIdentity = ObjectIdentity::fromDomainObject($obdoGroup);
                $acl = $aclProvider->createAcl($objectIdentity);
                //insert useracl
                $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('SuperAdmin'));
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);
                //insert useracl
                $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('Admin'));
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);
                //insert useracl
                $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('GroupAdmin'));
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);
                
                		// Feuguerolles-Bully Group
		$kuchiGroup1 = new KuchiGroup();
		$kuchiGroup1->setName('Feuguerolles-Bully');
                $kuchiGroup1->addUser($this->getReference('SuperAdmin'));
                $kuchiGroup1->addUser($this->getReference('Admin'));
                $kuchiGroup1->addUser($this->getReference('GroupAdmin'));
		$this->addReference('kuchiGroup1', $kuchiGroup1);
		$manager->persist($kuchiGroup1);
		$manager->flush();
		$kuchiGroup1->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $kuchiGroup1->getId() . "/logo.jpg" );
		$manager->persist($kuchiGroup1);
		$manager->flush();
                // create the ACL
                $aclProvider = $this->container->get('security.acl.provider');
                $objectIdentity = ObjectIdentity::fromDomainObject($kuchiGroup1);
                $acl = $aclProvider->createAcl($objectIdentity);
                //insert useracl
                $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('SuperAdmin'));
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);
                //insert useracl
                $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('Admin'));
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);
                //insert useracl
                $securityIdentity = UserSecurityIdentity::fromAccount($this->getReference('GroupAdmin'));
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
                $aclProvider->updateAcl($acl);                

	}
}