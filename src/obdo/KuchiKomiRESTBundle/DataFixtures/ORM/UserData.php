<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiUserBundle\Entity\User;

class UserData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		return 1;
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
		$manager->getConnection()->exec("ALTER TABLE User AUTO_INCREMENT = 1;");
		
		// super admin
		$userSuperAdmin = new User();
		$userSuperAdmin->setUsername('admin');
		$userSuperAdmin->setPlainPassword('admin');
		$userSuperAdmin->setEmail('nicolas.dries@ob-do.com');
		$userSuperAdmin->setLocked(false);
		$userSuperAdmin->setEnabled(true);
		$userSuperAdmin->setSuperAdmin(true);
		$manager->persist($userSuperAdmin);
		
		// Kuchi group admin
		$kuchiGroupAdmin = new User();
		$kuchiGroupAdmin->setUsername('kuchigroup');
		$kuchiGroupAdmin->setPlainPassword('kuchigroup');
		$kuchiGroupAdmin->setEmail('pascal.rouet@ob-do.com');
		$kuchiGroupAdmin->setLocked(false);
		$kuchiGroupAdmin->setEnabled(true);
		$kuchiGroupAdmin->setRoles(array('ROLE_ADMIN_GROUP_KUCHI'));
		$manager->persist($kuchiGroupAdmin);
		
		// Kuchi admin
		$kuchiAdmin = new User();
		$kuchiAdmin->setUsername('kuchi');
		$kuchiAdmin->setPlainPassword('kuchi');
		$kuchiAdmin->setEmail('mickael.boixiere@ob-do.com');
		$kuchiAdmin->setLocked(false);
		$kuchiAdmin->setEnabled(true);
		$kuchiAdmin->setRoles(array('ROLE_KUCHI'));
		$manager->persist($kuchiAdmin);

		$manager->flush();	
	}
}