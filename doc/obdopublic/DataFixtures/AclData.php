<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;


class AclData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		
		// Delete ACL
		$connection = $manager->getConnection();
		$connection->exec("DELETE FROM `kuchikomi`.`acl_entries`;");
                $connection->exec("ALTER TABLE acl_entries AUTO_INCREMENT = 1;");
                
                $connection->exec("DELETE FROM `kuchikomi`.`acl_object_identity_ancestors`;");
                $connection->exec("ALTER TABLE acl_object_identity_ancestors AUTO_INCREMENT = 1;");
                
		$connection->exec("DELETE FROM `kuchikomi`.`acl_object_identities`;");
                $connection->exec("ALTER TABLE acl_object_identities AUTO_INCREMENT = 1;");
                
                $connection->exec("DELETE FROM `kuchikomi`.`acl_classes`;");
                $connection->exec("ALTER TABLE acl_classes AUTO_INCREMENT = 1;");
                
		$connection->exec("DELETE FROM `kuchikomi`.`acl_security_identities`;");
                $connection->exec("ALTER TABLE acl_security_identities AUTO_INCREMENT = 1;");
	}
}