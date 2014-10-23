<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\KuchiAccount;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class KuchiAccountData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
				        
        $manager->getConnection()->exec("ALTER TABLE KuchiAccount AUTO_INCREMENT = 1;");
        

        $kuchiAccount0 = new KuchiAccount();        
        $kuchiAccount0->setKomi($this->getReference('komi1'));
        $kuchiAccount0->setKuchi($this->getReference('david'));
        
        $kuchiAccount = new KuchiAccount();        
        $kuchiAccount->setKomi($this->getReference('komi2'));
        $kuchiAccount->setKuchi($this->getReference('maxime'));
        
        $kuchiAccount4 = new KuchiAccount();        
        $kuchiAccount4->setKomi($this->getReference('komi3'));
        $kuchiAccount4->setKuchi($this->getReference('maxime'));        
        
        $kuchiAccount2 = new KuchiAccount();
        $kuchiAccount2->setKomi($this->getReference('komi3'));
        $kuchiAccount2->setKuchi($this->getReference('eva'));

        $kuchiAccount3 = new KuchiAccount();
        $kuchiAccount3->setKomi($this->getReference('komi3'));
        $kuchiAccount3->setKuchi($this->getReference('paul'));
        
        $manager->persist($kuchiAccount0);
        $manager->persist($kuchiAccount);
        $manager->persist($kuchiAccount2);
        $manager->persist($kuchiAccount3);
        $manager->persist($kuchiAccount4);
        $manager->flush();

    }

}