<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\Log;
use obdo\KuchiKomiRESTBundle\Entity\KuchiGroup;
use obdo\KuchiKomiUserBundle\Entity\User;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use obdo\KuchiKomiRESTBundle\Entity\Address;

class cleanBDD implements FixtureInterface
{
	// Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
	public function load(ObjectManager $manager)
	{
		// Reset auto-increment
		$connection = $manager->getConnection();
		$connection->exec("ALTER TABLE Address AUTO_INCREMENT = 1;");
		$connection->exec("ALTER TABLE Log AUTO_INCREMENT = 1;");
		$connection->exec("ALTER TABLE Kuchi AUTO_INCREMENT = 1;");
		$connection->exec("ALTER TABLE Komi AUTO_INCREMENT = 1;");
		$connection->exec("ALTER TABLE KuchiKomi AUTO_INCREMENT = 1;");
		$connection->exec("ALTER TABLE KuchiGroup AUTO_INCREMENT = 1;");
		$connection->exec("ALTER TABLE User AUTO_INCREMENT = 1;");
		
		// Users
		$user = new User();
		$user->setUsername('admin');
		$user->setPlainPassword('admin');
		$user->setEmail('nicolas.dries@ob-do.com');
		$user->setLocked(false);
		$user->setEnabled(true);
		$user->setSuperAdmin(true);
		$manager->persist($user);
		
		// Address
		$address1 = new Address();
		$address1->setAddress1('Rue de Caen');
		$address1->setAddress2('');
		$address1->setAddress3('');
		$address1->setPostalCode('14320');
		$address1->setCity('Feuguerolles-Bully');
		$manager->persist($address1);
		
		$address2 = new Address();
		$address2->setAddress1('Rue de Maltot');
		$address2->setAddress2('');
		$address2->setAddress3('');
		$address2->setPostalCode('14320');
		$address2->setCity('Feuguerolles-Bully');
		$manager->persist($address2);
		
		// Kuchi Group
		$kuchiGroup1 = new KuchiGroup();
		$kuchiGroup1->setName('Feuguerolles-Bully');
		$manager->persist($kuchiGroup1);
		
		
		// Kuchi
		$kuchi1_1 = new Kuchi();
		$kuchi1_1->setName('Mairie');
		$kuchi1_1->setKuchiGroup($kuchiGroup1);
		$kuchi1_1->setPassword('essai');
		$kuchi1_1->setAddress($address1);
		$manager->persist($kuchi1_1);
		
		$kuchi1_2 = new Kuchi();
		$kuchi1_2->setName('Médiathèque');
		$kuchi1_2->setKuchiGroup($kuchiGroup1);
		$kuchi1_2->setPassword('essai');
		$kuchi1_2->setAddress($address2);
		$manager->persist($kuchi1_2);
		
		// Log
		$newLog = new Log();
		$newLog->setLevel(Log::LEVEL_INFO);
		$newLog->setMessage("DATABASE CLEAN");
		$manager->persist($newLog);	
		
		$manager->flush();	
	}
}