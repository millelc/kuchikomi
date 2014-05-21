<?php

namespace obdo\KuchiKomiRESTBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use obdo\KuchiKomiRESTBundle\Entity\KuchiKomi;

class KuchiKomiData extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
		return 4;
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
		
		$manager->getConnection()->exec("ALTER TABLE KuchiKomi AUTO_INCREMENT = 1;");

		// KuchiKomi de bienvenue
		$welcome = new KuchiKomi();
		$welcome->setKuchi($this->getReference('news'));
		$welcome->setTitle('Bienvenue !');
		$welcome->setDetails("Toute l'équipe CityKomi est heureuse de vous accueillir comme nouveau membre !");
		$welcome->setTimestampEnd($welcome->getTimestampEnd()->add(new \DateInterval('P2D')));
		$this->addReference('welcome', $welcome);
		$manager->persist($welcome);
		
		
		// KuchiKomi
		$kuchikomi1 = new KuchiKomi();
		$kuchikomi1->setKuchi($this->getReference('kuchi1'));
		$kuchikomi1->setTitle('Nouveau kuchikomi 1');
		$kuchikomi1->setDetails('from clean BDD');
		$kuchikomi1->setTimestampEnd($kuchikomi1->getTimestampEnd()->add(new \DateInterval('P2D')));
		$kuchikomi1->setPhotoLink( $this->getReference('kuchi1')->getPhotoKuchiKomiLink() . "4fc22bb386cf91ec6e5967aa0148fa76.jpg" );
		$this->addReference('kuchikomi1', $kuchikomi1);
		$manager->persist($kuchikomi1);
		
		$manager->flush();	
	}
}