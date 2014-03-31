<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\Kuchi;

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
		$Password = $this->container->get('obdo_services.Password');
		
		$manager->getConnection()->exec("ALTER TABLE Kuchi AUTO_INCREMENT = 1;");
		
		// Kuchi1
		$kuchi1 = new Kuchi();
		$kuchi1->setName('Mairie');
		$kuchi1->setKuchiGroup($this->getReference('kuchiGroup1'));
		$kuchi1->setPassword($Password->generateHash('essai'));
		$kuchi1->setAddress($this->getReference('address1'));
		$this->addReference('kuchi1', $kuchi1);
		$manager->persist($kuchi1);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $kuchi1->getId();
		$kuchi1->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $kuchi1->getId();
		$kuchi1->setLogoLink($folder . "/logo.jpg");
		$kuchi1->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($kuchi1);
		$manager->flush();
		
		// Kuchi2
		$kuchi2 = new Kuchi();
		$kuchi2->setName('Médiathèque');
		$kuchi2->setKuchiGroup($this->getReference('kuchiGroup1'));
		$kuchi2->setPassword($Password->generateHash('essai'));
		$kuchi2->setAddress($this->getReference('address2'));
		$this->addReference('kuchi2', $kuchi2);
		$manager->persist($kuchi2);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $kuchi2->getId();
		$kuchi2->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $kuchi2->getId();
		$kuchi2->setLogoLink($folder . "/logo.jpg");
		$kuchi2->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($kuchi2);
		$manager->flush();
		
		// David
		$david = new Kuchi();
		$david->setName('David');
		$david->setKuchiGroup($this->getReference('obdoGroup'));
		$david->setPassword($Password->generateHash('david'));
		$david->setAddress($this->getReference('addressDavid'));
		$this->addReference('david', $david);
		$manager->persist($david);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $david->getId();
		$david->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $david->getId();
		$david->setLogoLink($folder . "/logo.jpg");
		$david->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($david);
		$manager->flush();
		
		// Nicolas
		$nicolas = new Kuchi();
		$nicolas->setName('Nicolas');
		$nicolas->setKuchiGroup($this->getReference('obdoGroup'));
		$nicolas->setPassword($Password->generateHash('nicolas'));
		$nicolas->setAddress($this->getReference('addressNicolas'));
		$this->addReference('nicolas', $nicolas);
		$manager->persist($nicolas);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $nicolas->getId();
		$nicolas->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $nicolas->getId();
		$nicolas->setLogoLink($folder . "/logo.jpg");
		$nicolas->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($nicolas);
		$manager->flush();
		
		// Julien
		$julien = new Kuchi();
		$julien->setName('Julien');
		$julien->setKuchiGroup($this->getReference('obdoGroup'));
		$julien->setPassword($Password->generateHash('julien'));
		$julien->setAddress($this->getReference('addressJulien'));
		$this->addReference('julien', $julien);
		$manager->persist($julien);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $julien->getId();
		$julien->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $julien->getId();
		$julien->setLogoLink($folder . "/logo.jpg");
		$julien->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($julien);
		$manager->flush();
		
		// Pascal
		$pascal = new Kuchi();
		$pascal->setName('Pascal');
		$pascal->setKuchiGroup($this->getReference('obdoGroup'));
		$pascal->setPassword($Password->generateHash('pascal'));
		$pascal->setAddress($this->getReference('addressPascal'));
		$this->addReference('pascal', $pascal);
		$manager->persist($pascal);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $pascal->getId();
		$pascal->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $pascal->getId();
		$pascal->setLogoLink($folder . "/logo.jpg");
		$pascal->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($pascal);
		$manager->flush();
		
		// Eric
		$eric = new Kuchi();
		$eric->setName('Eric');
		$eric->setKuchiGroup($this->getReference('obdoGroup'));
		$eric->setPassword($Password->generateHash('eric'));
		$eric->setAddress($this->getReference('addressEric'));
		$this->addReference('eric', $eric);
		$manager->persist($eric);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $eric->getId();
		$eric->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $eric->getId();
		$eric->setLogoLink($folder . "/logo.jpg");
		$eric->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($eric);
		$manager->flush();
		
		// Bruno
		$bruno = new Kuchi();
		$bruno->setName('Bruno');
		$bruno->setKuchiGroup($this->getReference('obdoGroup'));
		$bruno->setPassword($Password->generateHash('bruno'));
		$bruno->setAddress($this->getReference('addressBruno'));
		$this->addReference('bruno', $bruno);
		$manager->persist($bruno);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $bruno->getId();
		$bruno->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $bruno->getId();
		$bruno->setLogoLink($folder . "/logo.jpg");
		$bruno->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($bruno);
		$manager->flush();
		
		// Samuel
		$samuel = new Kuchi();
		$samuel->setName('Samuel');
		$samuel->setKuchiGroup($this->getReference('obdoGroup'));
		$samuel->setPassword($Password->generateHash('samuel'));
		$samuel->setAddress($this->getReference('addressSamuel'));
		$this->addReference('samuel', $samuel);
		$manager->persist($samuel);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $samuel->getId();
		$samuel->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $samuel->getId();
		$samuel->setLogoLink($folder . "/logo.jpg");
		$samuel->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($samuel);
		$manager->flush();
		
		// Alain
		$alain = new Kuchi();
		$alain->setName('Alain');
		$alain->setKuchiGroup($this->getReference('obdoGroup'));
		$alain->setPassword($Password->generateHash('alain'));
		$alain->setAddress($this->getReference('addressAlain'));
		$this->addReference('alain', $alain);
		$manager->persist($alain);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $alain->getId();
		$alain->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $alain->getId();
		$alain->setLogoLink($folder . "/logo.jpg");
		$alain->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($alain);
		$manager->flush();
		
		// Mickael
		$mickael = new Kuchi();
		$mickael->setName('Mickael');
		$mickael->setKuchiGroup($this->getReference('obdoGroup'));
		$mickael->setPassword($Password->generateHash('mickael'));
		$mickael->setAddress($this->getReference('addressMickael'));
		$this->addReference('mickael', $mickael);
		$manager->persist($mickael);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $mickael->getId();
		$mickael->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $mickael->getId();
		$mickael->setLogoLink($folder . "/logo.jpg");
		$mickael->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($mickael);
		$manager->flush();
		
		// Paul
		$paul = new Kuchi();
		$paul->setName('Paul');
		$paul->setKuchiGroup($this->getReference('obdoGroup'));
		$paul->setPassword($Password->generateHash('paul'));
		$paul->setAddress($this->getReference('addressPaul'));
		$this->addReference('paul', $paul);
		$manager->persist($paul);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') .$paul->getId();
		$paul->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $paul->getId();
		$paul->setLogoLink($folder . "/logo.jpg");
		$paul->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($paul);
		$manager->flush();
		
		// Eva
		$eva = new Kuchi();
		$eva->setName('Eva');
		$eva->setKuchiGroup($this->getReference('obdoGroup'));
		$eva->setPassword($Password->generateHash('eva'));
		$eva->setAddress($this->getReference('addressEva'));
		$this->addReference('eva', $eva);
		$manager->persist($eva);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $eva->getId();
		$eva->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $eva->getId();
		$eva->setLogoLink($folder . "/logo.jpg");
		$eva->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($eva);
		$manager->flush();
		
		// Maxime
		$maxime = new Kuchi();
		$maxime->setName('Maxime');
		$maxime->setKuchiGroup($this->getReference('obdoGroup'));
		$maxime->setPassword($Password->generateHash('maxime'));
		$maxime->setAddress($this->getReference('addressMaxime'));
		$this->addReference('maxime', $maxime);
		$manager->persist($maxime);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $maxime->getId();
		$maxime->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $maxime->getId();
		$maxime->setLogoLink($folder . "/logo.jpg");
		$maxime->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($maxime);
		$manager->flush();
		
		
	}
}