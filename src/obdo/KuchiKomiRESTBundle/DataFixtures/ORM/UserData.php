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
		$userSuperAdmin->setUsername('root');
		$userSuperAdmin->setPlainPassword('root');
		$userSuperAdmin->setEmail('nicolas.dries@ob-do.com');
		$userSuperAdmin->setLocked(false);
		$userSuperAdmin->setEnabled(true);
		$userSuperAdmin->setSuperAdmin(true);
                $this->addReference('SuperAdmin', $userSuperAdmin);
		$manager->persist($userSuperAdmin);
		
                // admin
		$userAdmin = new User();
		$userAdmin->setUsername('admin');
		$userAdmin->setPlainPassword('admin');
		$userAdmin->setEmail('david.marechal@ob-do.com');
		$userAdmin->setLocked(false);
		$userAdmin->setEnabled(true);
		$userAdmin->setRoles(array('ROLE_ADMIN'));
                $this->addReference('Admin', $userAdmin);
		$manager->persist($userAdmin);
                
		// Kuchi group admin
		$kuchiGroupAdmin = new User();
		$kuchiGroupAdmin->setUsername('kuchigroup');
		$kuchiGroupAdmin->setPlainPassword('kuchigroup');
		$kuchiGroupAdmin->setEmail('pascal.rouet@ob-do.com');
		$kuchiGroupAdmin->setLocked(false);
		$kuchiGroupAdmin->setEnabled(true);
		$kuchiGroupAdmin->setRoles(array('ROLE_ADMIN_GROUP_KUCHI'));
                $this->addReference('GroupAdmin', $kuchiGroupAdmin);
		$manager->persist($kuchiGroupAdmin);
		
		// Kuchi admin
		$kuchiAdmin = new User();
		$kuchiAdmin->setUsername('kuchi');
		$kuchiAdmin->setPlainPassword('kuchi');
		$kuchiAdmin->setEmail('mickael.boixiere@ob-do.com');
		$kuchiAdmin->setLocked(false);
		$kuchiAdmin->setEnabled(true);
		$kuchiAdmin->setRoles(array('ROLE_KUCHI'));
                $this->addReference('KuchiAdmin', $kuchiAdmin);
		$manager->persist($kuchiAdmin);

		$manager->flush();	
                
                /*************************************************************/
                
                $this->createUser($manager, 'User_test_PostKuchiKomiAction_1', 'usertestPostKuchiKomi', 'test@ob-do.com', array('ROLE_KUCHI'));
                
	}
        
        private function createUser($manager,$name,$password,$mail,$roles,$locked=false,$enabled=true){
            $user = new User ();
            $user->setUsername($name);
            $user->setPlainPassword($password);
            $user->setEmail($mail);
            $user->setLocked($locked);
            $user->setEnabled($enabled);
            $user->setRoles($roles);
            $this->addReference($name, $user);
            $manager->persist($user);
            $manager->flush();                        
        }
}