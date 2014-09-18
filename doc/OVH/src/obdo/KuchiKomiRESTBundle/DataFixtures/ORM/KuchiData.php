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
        $AclManager = $this->container->get('obdo_services.AclManager');

        $manager->getConnection()->exec("ALTER TABLE Kuchi AUTO_INCREMENT = 1;");

        // News
        $news = new Kuchi();
        $news->setName('News');
        $news->setPhoneNumber('');
        $news->setMailAddress('news@citykomi.com');
        $news->setWebSite('www.citykomi.com');
        $news->setKuchiGroup($this->getReference('citykomiGroup'));
        $news->setPassword($Password->generateHash('news'));
        $news->setAddress($this->getReference('addressNews'));
        $this->addReference('news', $news);
        $manager->persist($news);
        $manager->flush();
        $folder = $this->container->getParameter('path_kuchikomi_photo') . $news->getId();
        $news->setPhotoKuchiKomiLink($folder . "/");
        $folder = $this->container->getParameter('path_kuchi_photo') . $news->getId();
        $news->setLogoLink($folder . "/logo.jpg");
        $news->setPhotoLink($folder . "/photo.jpg");
        $manager->persist($news);
        $manager->flush();
        // ACL
        $AclManager->addAcl($news, $this->getReference('SuperAdmin'));                       

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
    }
}