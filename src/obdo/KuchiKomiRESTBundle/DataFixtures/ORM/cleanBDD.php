<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\Log;
use obdo\KuchiKomiRESTBundle\Entity\KuchiGroup;
use obdo\KuchiKomiUserBundle\Entity\User;
use obdo\KuchiKomiRESTBundle\Entity\Kuchi;
use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;
use obdo\KuchiKomiRESTBundle\Entity\Komi;
use obdo\KuchiKomiRESTBundle\Entity\Address;
use obdo\KuchiKomiRESTBundle\Entity\Subscription;
use obdo\KuchiKomiRESTBundle\Entity\Thanks;

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
		
// 		$address3 = new Address();
// 		$address3->setAddress1('Rue de Maltot');
// 		$address3->setAddress2('');
// 		$address3->setAddress3('');
// 		$address3->setPostalCode('14320');
// 		$address3->setCity('Feuguerolles-Bully');
// 		$manager->persist($address3);
		
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
		
// 		$kuchi1_3 = new Kuchi();
// 		$kuchi1_3->setName('Kuchi supprimé');
// 		$kuchi1_3->setKuchiGroup($kuchiGroup1);
// 		$kuchi1_3->setPassword('essai');
// 		$kuchi1_3->setAddress($address3);
// 		$kuchi1_3->setActive(false);
// 		$manager->persist($kuchi1_3);

		// new Komi
		$komi1 = new Komi();
		$komi1->setRandomId('Nicolas');
		$komi1->setOsType(0);
		$komi1->setApplicationVersion( '2.0.0' );
		$komi1->setGcmRegId('sdfsdgrstyhrffsdggh');
		$manager->persist($komi1);
		
		$manager->flush();
		
		// subscription
		$subscription1 = new Subscription();
		$subscription1->setKomi($komi1);
		$subscription1->setKuchi($kuchi1_1);
		$subscription1->setType(0);
		$manager->persist($subscription1);
		
// 		$subscription2 = new Subscription();
// 		$subscription2->setKomi($komi1);
// 		$subscription2->setKuchi($kuchi1_3);
// 		$subscription2->setType(0);
// 		$manager->persist($subscription2);
		
		// KuchiKomi
		$kuchikomi1 = new KuchiKomi();
		$kuchikomi1->setKuchi($kuchi1_1);
		$kuchikomi1->setTitle('Nouveau kuchikomi 1');
		$kuchikomi1->setDetails('from clean BDD');
		//$endDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
		//$endDate->add('P2D');
		$kuchikomi1->setTimestampEnd($kuchikomi1->getTimestampEnd()->add(new \DateInterval('P2D')));
		$manager->persist($kuchikomi1);
		$manager->flush();
		
		// Thanks
// 		$thanks1 = new Thanks();
// 		$thanks1->setKomi($komi1);
// 		$thanks1->setKuchiKomi($kuchikomi1);
// 		$manager->persist($thanks1);
// 		$manager->flush();
		
		// Log
		$newLog = new Log();
		$newLog->setLevel(Log::LEVEL_INFO);
		$newLog->setMessage("DATABASE CLEAN");
		$manager->persist($newLog);	
		
		$manager->flush();	
	}
}