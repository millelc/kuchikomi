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

        $AclManager = $this->container->get('obdo_services.AclManager');

        // CityKomi Group
        $citykomiGroup = new KuchiGroup();
        $citykomiGroup->setName("CityKomi");
        $citykomiGroup->addUser($this->getReference('SuperAdmin'));
        $this->addReference('citykomiGroup', $citykomiGroup);
        $manager->persist($citykomiGroup);
        $manager->flush();
        $citykomiGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $citykomiGroup->getId() . "/logo.jpg" );
        $manager->persist($citykomiGroup);
        $manager->flush();
        //  ACL
        $AclManager->addAcl($citykomiGroup, $this->getReference('SuperAdmin'));

        // ob-do Group
        $obdoGroup = new KuchiGroup();
        $obdoGroup->setName("ob'do");
        $obdoGroup->addUser($this->getReference('SuperAdmin'));
        $this->addReference('obdoGroup', $obdoGroup);
        $manager->persist($obdoGroup);
        $manager->flush();
        $obdoGroup->setLogo( $this->container->getParameter('path_kuchigroup_photo') . $obdoGroup->getId() . "/logo.jpg" );
        $manager->persist($obdoGroup);
        $manager->flush();
        // ACL
        $AclManager->addAcl($obdoGroup, $this->getReference('SuperAdmin'));             

    }

}