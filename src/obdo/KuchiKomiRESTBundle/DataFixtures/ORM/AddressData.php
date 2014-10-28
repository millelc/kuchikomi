<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\Address;

class AddressData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		$manager->getConnection()->exec("ALTER TABLE Address AUTO_INCREMENT = 1;");
		
		
		
		// Address David
		$addressDavid = new Address();
		$addressDavid->setAddress1("38, rue de l'Europe");
		$addressDavid->setAddress2('');
		$addressDavid->setAddress3('');
		$addressDavid->setPostalCode('14610');
		$addressDavid->setCity('Cairon');
		$this->addReference('addressDavid', $addressDavid);
		$manager->persist($addressDavid);

		// Address Julien
		$addressJulien = new Address();
		$addressJulien->setAddress1("4, rue de l'ancienne Mairie");
		$addressJulien->setAddress2('');
		$addressJulien->setAddress3('');
		$addressJulien->setPostalCode('14830');
		$addressJulien->setCity("Langrune sur Mer");
		$this->addReference('addressJulien', $addressJulien);
		$manager->persist($addressJulien);
		
		// Address Bruno
		$addressBruno = new Address();
		$addressBruno->setAddress1("16, Longue Vue du Théatre");
		$addressBruno->setAddress2('');
		$addressBruno->setAddress3('');
		$addressBruno->setPostalCode('14111');
		$addressBruno->setCity('Louvigny');
		$this->addReference('addressBruno', $addressBruno);
		$manager->persist($addressBruno);
		
		// Address Pascal
		$addressPascal = new Address();
		$addressPascal->setAddress1("6, rue André Tack");
		$addressPascal->setAddress2('');
		$addressPascal->setAddress3('');
		$addressPascal->setPostalCode('14112');
		$addressPascal->setCity("Bièville-Beuville");
		$this->addReference('addressPascal', $addressPascal);
		$manager->persist($addressPascal);
		
		// Address Nicolas
		$addressNicolas = new Address();
		$addressNicolas->setAddress1("5, La Bruyère");
		$addressNicolas->setAddress2('');
		$addressNicolas->setAddress3('');
		$addressNicolas->setPostalCode('14320');
		$addressNicolas->setCity('Feuguerolles-Bully');
		$this->addReference('addressNicolas', $addressNicolas);
		$manager->persist($addressNicolas);
		
		// Address Eric
		$addressEric = new Address();
		$addressEric->setAddress1("9, Boulevard de la 6eme Airborne");
		$addressEric->setAddress2('');
		$addressEric->setAddress3('');
		$addressEric->setPostalCode('14970');
		$addressEric->setCity("Bénouville");
		$this->addReference('addressEric', $addressEric);
		$manager->persist($addressEric);
		
		// Address Mickael
		$addressMickael = new Address();
		$addressMickael->setAddress1("ob'do");
		$addressMickael->setAddress2("Bureau en face de Pascal");
		$addressMickael->setAddress3('');
		$addressMickael->setPostalCode('14460');
		$addressMickael->setCity("Colombelles");
		$this->addReference('addressMickael', $addressMickael);
		$manager->persist($addressMickael);
		
		// Address Paul
		$addressPaul = new Address();
		$addressPaul->setAddress1("ob'do");
		$addressPaul->setAddress2("Bureau en face de Nicolas");
		$addressPaul->setAddress3('');
		$addressPaul->setPostalCode('14460');
		$addressPaul->setCity("Colombelles");
		$this->addReference('addressPaul', $addressPaul);
		$manager->persist($addressPaul);

		// Address Samuel
		$addressSamuel = new Address();
		$addressSamuel->setAddress1("ob'do");
		$addressSamuel->setAddress2("Bureau en face de Julien");
		$addressSamuel->setAddress3('');
		$addressSamuel->setPostalCode('14460');
		$addressSamuel->setCity("Colombelles");
		$this->addReference('addressSamuel', $addressSamuel);
		$manager->persist($addressSamuel);
		
		// Address Alain
		$addressAlain = new Address();
		$addressAlain->setAddress1("ob'do");
		$addressAlain->setAddress2("Bureau en face de David");
		$addressAlain->setAddress3('');
		$addressAlain->setPostalCode('14460');
		$addressAlain->setCity("Colombelles");
		$this->addReference('addressAlain', $addressAlain);
		$manager->persist($addressAlain);
		
		// Address Eva
		$addressEva = new Address();
		$addressEva->setAddress1("ob'do");
		$addressEva->setAddress2("Bureau en face d'Eric");
		$addressEva->setAddress3('');
		$addressEva->setPostalCode('14460');
		$addressEva->setCity("Colombelles");
		$this->addReference('addressEva', $addressEva);
		$manager->persist($addressEva);
		
		// Address Maxime
		$addressMaxime = new Address();
		$addressMaxime->setAddress1("ob'do");
		$addressMaxime->setAddress2("Bureau en face de Bruno");
		$addressMaxime->setAddress3('');
		$addressMaxime->setPostalCode('14460');
		$addressMaxime->setCity("Colombelles");
		$this->addReference('addressMaxime', $addressMaxime);
		$manager->persist($addressMaxime);

		$fbAddress = new Address();
		$fbAddress->setAddress1('Rue de Maltot');
		$fbAddress->setAddress2('');
		$fbAddress->setAddress3('');
		$fbAddress->setPostalCode('14320');
		$fbAddress->setCity('Feuguerolles-Bully');
		$this->addReference('fbAddress', $fbAddress);
		$manager->persist($fbAddress);
                
                $tb1Address = new Address();
		$tb1Address->setAddress1('Rue de Maltot');
		$tb1Address->setAddress2('');
		$tb1Address->setAddress3('');
		$tb1Address->setPostalCode('14320');
		$tb1Address->setCity('Feuguerolles-Bully');
		$this->addReference('tb1Address', $tb1Address);
		$manager->persist($tb1Address);
		
                $tb2Address = new Address();
		$tb2Address->setAddress1('Rue de Maltot');
		$tb2Address->setAddress2('');
		$tb2Address->setAddress3('');
		$tb2Address->setPostalCode('14320');
		$tb2Address->setCity('Feuguerolles-Bully');
		$this->addReference('tb2Address', $tb2Address);
		$manager->persist($tb2Address);
                
                /****************************************************/
                $this->createAddress($manager, "kuchi_test_News_address");
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionAction_1_address");
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionAction_2_address");
                $this->createAddress($manager, "kuchi_test_N_PostSubscriptionAction_1_address");
                $this->createAddress($manager, "kuchi_test_N_PostSubscriptionAction_4_address");
                $this->createAddress($manager, "kuchi_test_N_PostSubscriptionAction_5_address");
                $this->createAddress($manager, "kuchi_test_N_PostSubscriptionAction_6_address");
                $this->createAddress($manager, "kuchi_test_P_DeleteSubscriptionAction_1_address");
                $this->createAddress($manager, "kuchi_test_N_DeleteSubscriptionAction_1_address");
                $this->createAddress($manager, "kuchi_test_N_DeleteSubscriptionAction_3_address");
                $this->createAddress($manager, "kuchi_test_N_DeleteSubscriptionAction_4_address");
                $this->createAddress($manager, "kuchi_test_P_PostKuchiKomiAction_1_address");
                $this->createAddress($manager, "kuchi_test_P_DeleteKuchiKomiAction_1_address");               
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionGroupAction_2_1_address");
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionGroupAction_2_2_address");
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionGroupAction_3_1_address");
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionGroupAction_3_2_address");
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionGroupAction_4_1_address");
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionGroupAction_4_2_address");
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionGroupAction_5_1_address");
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionGroupAction_5_2_address");
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionGroupAction_6_1_address");
                $this->createAddress($manager, "kuchi_test_P_PostSubscriptionGroupAction_6_2_address");
                $this->createAddress($manager, "kuchi_test_P_DeleteSubscriptionGroupAction_3_1_address");
                $this->createAddress($manager, "kuchi_test_P_DeleteSubscriptionGroupAction_3_2_address");
                $this->createAddress($manager, "kuchi_test_P_DeleteSubscriptionGroupAction_4_1_address");
                $this->createAddress($manager, "kuchi_test_P_DeleteSubscriptionGroupAction_4_2_address");
                $this->createAddress($manager, "kuchi_test_N_DeleteSubscriptionGroupAction_8_1_address");
                $this->createAddress($manager, "kuchi_test_N_DeleteSubscriptionGroupAction_8_2_address");
                $this->createAddress($manager, "kuchi_test_N_DeleteSubscriptionGroupAction_9_1_address");
                $this->createAddress($manager, "kuchi_test_N_DeleteSubscriptionGroupAction_9_2_address");
                
                $manager->flush();	

	}
        
        private function createAddress($manager, $name)
        {
            $Address_test = new Address();
            $Address_test->setAddress1($name."_1");
            $Address_test->setAddress2($name."_2");
            $Address_test->setAddress3($name."_3");
            $Address_test->setPostalCode("14000");
            $Address_test->setCity($name."_city");
            $this->addReference($name, $Address_test);
            $manager->persist($Address_test);
        }
}