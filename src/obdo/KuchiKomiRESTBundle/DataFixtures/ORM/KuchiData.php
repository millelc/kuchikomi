<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\Kuchi;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

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
		return 3;
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
		$AclManager = $this->container->get('obdo_services.AclManager');
                
                 
		
		// David
		$david = new Kuchi();
		$david->setName('David');
		$david->setPhoneNumber('00 00 00 00 03');
		$david->setMailAddress('david.marechal@ob-do.com');
		$david->setWebSite('www.ob-do.com');
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
                // ACL
                $AclManager->addAcl($david, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($david, $this->getReference('Admin')); 
		
		// Nicolas
		$nicolas = new Kuchi();
		$nicolas->setName('Nicolas');
		$nicolas->setPhoneNumber('00 00 00 00 04');
		$nicolas->setMailAddress('nicolas.dries@ob-do.com');
		$nicolas->setWebSite('www.ob-do.com');		
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
                // ACL
                $AclManager->addAcl($nicolas, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($nicolas, $this->getReference('Admin'));
		
		// Julien
		$julien = new Kuchi();
		$julien->setName('Julien');
		$julien->setPhoneNumber('00 00 00 00 05');
		$julien->setMailAddress('julien.marie@ob-do.com');
		$julien->setWebSite('www.ob-do.com');		
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
                // ACL
                $AclManager->addAcl($julien, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($julien, $this->getReference('Admin'));
		
		// Pascal
		$pascal = new Kuchi();
		$pascal->setName('Pascal');
		$pascal->setPhoneNumber('00 00 00 00 06');
		$pascal->setMailAddress('pascal.rouet@ob-do.com');
		$pascal->setWebSite('www.ob-do.com');		
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
                // ACL
                $AclManager->addAcl($pascal, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($pascal, $this->getReference('Admin'));
		
		
		// Eric
		$eric = new Kuchi();
		$eric->setName('Eric');
		$eric->setPhoneNumber('00 00 00 00 07');
		$eric->setMailAddress('eric.goujou@ob-do.com');
		$eric->setWebSite('www.ob-do.com');		
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
                // ACL
                $AclManager->addAcl($eric, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($eric, $this->getReference('Admin'));
		
		// Bruno
		$bruno = new Kuchi();
		$bruno->setName('Bruno');
		$bruno->setPhoneNumber('00 00 00 00 08');
		$bruno->setMailAddress('bruno.perennou@ob-do.com');
		$bruno->setWebSite('www.ob-do.com');		
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
                // ACL
                $AclManager->addAcl($bruno, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($bruno, $this->getReference('Admin'));
		
		// Samuel
		$samuel = new Kuchi();
		$samuel->setName('Samuel');
		$samuel->setPhoneNumber('00 00 00 00 09');
		$samuel->setMailAddress('samuel.lioult@ob-do.com');
		$samuel->setWebSite('www.ob-do.com');		
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
                // ACL
                $AclManager->addAcl($samuel, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($samuel, $this->getReference('Admin'));
                
		// Alain
		$alain = new Kuchi();
		$alain->setName('Alain');
		$alain->setPhoneNumber('00 00 00 00 10');
		$alain->setMailAddress('alain.werck@ob-do.com');
		$alain->setWebSite('www.ob-do.com');		
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
                // ACL
                $AclManager->addAcl($alain, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($alain, $this->getReference('Admin'));
		
		// Mickael
		$mickael = new Kuchi();
		$mickael->setName('Mickael');
		$mickael->setPhoneNumber('00 00 00 00 11');
		$mickael->setMailAddress('mickael.boixiere@ob-do.com');
		$mickael->setWebSite('www.ob-do.com');		
		$mickael->setKuchiGroup($this->getReference('obdoGroup'));
		$mickael->setPassword($Password->generateHash('mike'));
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
                // ACL
                $AclManager->addAcl($mickael, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($mickael, $this->getReference('Admin'));
		
		// Paul
		$paul = new Kuchi();
		$paul->setName('Paul');
		$paul->setPhoneNumber('00 00 00 00 12');
		$paul->setMailAddress('paul.vibert@ob-do.com');
		$paul->setWebSite('www.ob-do.com');		
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
                // ACL
                $AclManager->addAcl($paul, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($paul, $this->getReference('Admin'));
		
		// Eva
		$eva = new Kuchi();
		$eva->setName('Eva');
		$eva->setPhoneNumber('00 00 00 00 13');
		$eva->setMailAddress('eva.landon@ob-do.com');
		$eva->setWebSite('www.ob-do.com');		
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
                // ACL
                $AclManager->addAcl($eva, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($eva, $this->getReference('Admin'));
		
		// Maxime
		$maxime = new Kuchi();
		$maxime->setName('Maxime');
		$maxime->setPhoneNumber('00 00 00 00 14');
		$maxime->setMailAddress('maxime.marie@ob-do.com');
		$maxime->setWebSite('www.ob-do.com');		
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
                $maxime->setActive(FALSE);
		$manager->persist($maxime);
		$manager->flush();
                // ACL
                $AclManager->addAcl($maxime, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($maxime, $this->getReference('Admin'));
                
                // toBeDeleted1
		$toBeDeleted1 = new Kuchi();
		$toBeDeleted1->setName('toBeDeleted1');
		$toBeDeleted1->setPhoneNumber('00 00 00 00 14');
		$toBeDeleted1->setMailAddress('maxime.marie@ob-do.com');
		$toBeDeleted1->setWebSite('www.ob-do.com');		
		$toBeDeleted1->setKuchiGroup($this->getReference('toBeDeletedGroup'));
		$toBeDeleted1->setPassword($Password->generateHash('maxime'));
		$toBeDeleted1->setAddress($this->getReference('tb1Address'));
                $toBeDeleted1->addUser($this->getReference('GroupAdmin'));
                $toBeDeleted1->addUser($this->getReference('KuchiAdmin'));
		$this->addReference('toBeDeleted1', $toBeDeleted1);
		$manager->persist($toBeDeleted1);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $toBeDeleted1->getId();
		$toBeDeleted1->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $toBeDeleted1->getId();
		$toBeDeleted1->setLogoLink($folder . "/logo.jpg");
		$toBeDeleted1->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($toBeDeleted1);
		$manager->flush();
                // ACL
                $AclManager->addAcl($toBeDeleted1, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($toBeDeleted1, $this->getReference('Admin'));
                $AclManager->addAcl($toBeDeleted1, $this->getReference('GroupAdmin'));
                $AclManager->addAcl($toBeDeleted1, $this->getReference('KuchiAdmin')); 
                
                // toBeDeleted2
		$toBeDeleted2 = new Kuchi();
		$toBeDeleted2->setName('toBeDeleted2');
		$toBeDeleted2->setPhoneNumber('00 00 00 00 14');
		$toBeDeleted2->setMailAddress('maxime.marie@ob-do.com');
		$toBeDeleted2->setWebSite('www.ob-do.com');		
		$toBeDeleted2->setKuchiGroup($this->getReference('toBeDeletedGroup'));
		$toBeDeleted2->setPassword($Password->generateHash('maxime'));
		$toBeDeleted2->setAddress($this->getReference('tb2Address'));
		$this->addReference('toBeDeleted2', $toBeDeleted2);
		$manager->persist($toBeDeleted2);
		$manager->flush();
		$folder = $this->container->getParameter('path_kuchikomi_photo') . $toBeDeleted2->getId();
		$toBeDeleted2->setPhotoKuchiKomiLink($folder . "/");
		$folder = $this->container->getParameter('path_kuchi_photo') . $toBeDeleted2->getId();
		$toBeDeleted2->setLogoLink($folder . "/logo.jpg");
		$toBeDeleted2->setPhotoLink($folder . "/photo.jpg");
		$manager->persist($toBeDeleted2);
		$manager->flush();
                // ACL
                $AclManager->addAcl($toBeDeleted2, $this->getReference('SuperAdmin'));
                $AclManager->addAcl($toBeDeleted2, $this->getReference('Admin'));
                $AclManager->addAcl($toBeDeleted2, $this->getReference('GroupAdmin'));
		
                
                /****************************************************/
                $this->createKuchi($manager, $AclManager, $Password, "News", "00 00 00 00 00", "news@citykomi.com", "www.citykomi.com", "CityKomi", "News", "kuchi_test_News_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionAction_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "P_PostSubscriptionAction_1", "kuchi_test_P_PostSubscriptionAction_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionAction_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "P_PostSubscriptionAction_2", "kuchi_test_P_PostSubscriptionAction_2_address");
                $this->createKuchi($manager, $AclManager, $Password, "N_PostSubscriptionAction_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_PostSubscriptionAction_1", "kuchi_test_N_PostSubscriptionAction_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "N_PostSubscriptionAction_4", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_PostSubscriptionAction_4", "kuchi_test_N_PostSubscriptionAction_4_address", false);
                $this->createKuchi($manager, $AclManager, $Password, "N_PostSubscriptionAction_5", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_PostSubscriptionAction_5", "kuchi_test_N_PostSubscriptionAction_5_address");
                $this->createKuchi($manager, $AclManager, $Password, "N_PostSubscriptionAction_6", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_PostSubscriptionAction_6", "kuchi_test_N_PostSubscriptionAction_6_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_DeleteSubscriptionAction_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "P_DeleteSubscriptionAction_1", "kuchi_test_P_DeleteSubscriptionAction_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionAction_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_DeleteSubscriptionAction_1", "kuchi_test_N_DeleteSubscriptionAction_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionAction_3", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_DeleteSubscriptionAction_3", "kuchi_test_N_DeleteSubscriptionAction_3_address");
                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionAction_4", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "N_DeleteSubscriptionAction_4", "kuchi_test_N_DeleteSubscriptionAction_4_address");

                $this->createKuchi($manager, $AclManager, $Password, "P_PostKuchiKomiAction_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_P_PostKuchiKomiAction_1", "P_PostKuchiKomiAction", "kuchi_test_P_PostKuchiKomiAction_1_address",$user=true);
                $this->createKuchi($manager, $AclManager, $Password, "P_DeleteKuchiKomiAction_1","00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "Group_test", "P_DeleteKuchiKomiAction_1", "kuchi_test_P_DeleteKuchiKomiAction_1_address");


                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_2_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_2", "P_PostSubscriptionGroupAction_2_1", "kuchi_test_P_PostSubscriptionGroupAction_2_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_2_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_2", "P_PostSubscriptionGroupAction_2_2", "kuchi_test_P_PostSubscriptionGroupAction_2_2_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_3_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_3", "P_PostSubscriptionGroupAction_3_1", "kuchi_test_P_PostSubscriptionGroupAction_3_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_3_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_3", "P_PostSubscriptionGroupAction_3_2", "kuchi_test_P_PostSubscriptionGroupAction_3_2_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_4_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_4", "P_PostSubscriptionGroupAction_4_1", "kuchi_test_P_PostSubscriptionGroupAction_4_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_4_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_4", "P_PostSubscriptionGroupAction_4_2", "kuchi_test_P_PostSubscriptionGroupAction_4_2_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_5_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_5", "P_PostSubscriptionGroupAction_5_1", "kuchi_test_P_PostSubscriptionGroupAction_5_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_5_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_5", "P_PostSubscriptionGroupAction_5_2", "kuchi_test_P_PostSubscriptionGroupAction_5_2_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_6_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_6", "P_PostSubscriptionGroupAction_6_1", "kuchi_test_P_PostSubscriptionGroupAction_6_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_PostSubscriptionGroupAction_6_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_PostSubscriptionGroupAction_6", "P_PostSubscriptionGroupAction_6_2", "kuchi_test_P_PostSubscriptionGroupAction_6_2_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_DeleteSubscriptionGroupAction_3_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_DeleteSubscriptionGroupAction_3", "P_DeleteSubscriptionGroupAction_3_1", "kuchi_test_P_DeleteSubscriptionGroupAction_3_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_DeleteSubscriptionGroupAction_3_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_DeleteSubscriptionGroupAction_3", "P_DeleteSubscriptionGroupAction_3_2", "kuchi_test_P_DeleteSubscriptionGroupAction_3_2_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_DeleteSubscriptionGroupAction_4_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_DeleteSubscriptionGroupAction_4", "P_DeleteSubscriptionGroupAction_4_1", "kuchi_test_P_DeleteSubscriptionGroupAction_4_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "P_DeleteSubscriptionGroupAction_4_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "P_DeleteSubscriptionGroupAction_4", "P_DeleteSubscriptionGroupAction_4_2", "kuchi_test_P_DeleteSubscriptionGroupAction_4_2_address");
                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionGroupAction_8_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "N_DeleteSubscriptionGroupAction_8", "N_DeleteSubscriptionGroupAction_8_1", "kuchi_test_N_DeleteSubscriptionGroupAction_8_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionGroupAction_8_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "N_DeleteSubscriptionGroupAction_8", "N_DeleteSubscriptionGroupAction_8_2", "kuchi_test_N_DeleteSubscriptionGroupAction_8_2_address");
                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionGroupAction_9_1", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "N_DeleteSubscriptionGroupAction_9", "N_DeleteSubscriptionGroupAction_9_1", "kuchi_test_N_DeleteSubscriptionGroupAction_9_1_address");
                $this->createKuchi($manager, $AclManager, $Password, "N_DeleteSubscriptionGroupAction_9_2", "00 00 00 00 00", "test@citykomi.com", "www.citykomi.com", "N_DeleteSubscriptionGroupAction_9", "N_DeleteSubscriptionGroupAction_9_2", "kuchi_test_N_DeleteSubscriptionGroupAction_9_2_address");
                
        }
        
        private function createKuchi($manager, $AclManager, $Password, $name, $phoneNumber, $mail, $webSite, $kuchiGroupRef, $password, $addressRef, $active=true, $user=false)
        {
            $kuchi_test = new Kuchi();
            $kuchi_test->setName($name);
            $kuchi_test->setPhoneNumber($phoneNumber);
            $kuchi_test->setMailAddress($mail);
            $kuchi_test->setWebSite($webSite);		
            $kuchi_test->setKuchiGroup($this->getReference($kuchiGroupRef));
            $kuchi_test->setPassword($Password->generateHash($password));
            $kuchi_test->setAddress($this->getReference($addressRef));
            $kuchi_test->setActive($active);
            if($user){
            $kuchi_test->addUser($this->getReference('User_test_PostKuchiKomiAction_1'));
            }
            $this->addReference("kuchiRef_".$name, $kuchi_test);
            $manager->persist($kuchi_test);
            $manager->flush();
            $folder = $this->container->getParameter('path_kuchikomi_photo') . $kuchi_test->getId();
            $kuchi_test->setPhotoKuchiKomiLink($folder . "/");
            $folder = $this->container->getParameter('path_kuchi_photo') . $kuchi_test->getId();
            $kuchi_test->setLogoLink($folder . "/logo.jpg");
            $kuchi_test->setPhotoLink($folder . "/photo.jpg");
            $manager->persist($kuchi_test);
            $manager->flush();
            // ACL
            $AclManager->addAcl($kuchi_test, $this->getReference('SuperAdmin'));
            $AclManager->addAcl($kuchi_test, $this->getReference('Admin'));
            $AclManager->addAcl($kuchi_test, $this->getReference('GroupAdmin'));
        }
        
}