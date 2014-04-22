<?php
namespace obdo\KuchiKomiRESTBundle\Tests\Entity;

use obdo\KuchiKomiRESTBundle\Entity\Address;

class AddressTest extends \PHPUnit_Framework_TestCase
{
	public function testNew()
	{
		$address = new Address();

		$this->assertEquals("", $address->getAddress1());
		$this->assertEquals("", $address->getAddress2());
		$this->assertEquals("", $address->getAddress3());
		$this->assertEquals("", $address->getPostalCode());
		$this->assertEquals("", $address->getCity());
	}

	public function testGetSet()
	{
		$address = new Address();

		$address->setAddress1("test 1");
		$address->setAddress2("test 2");
		$address->setAddress3("test 3");
		$address->setPostalCode("14320");
		$address->setCity("Feuguerolles-Bully");
		
		$this->assertEquals("test 1", $address->getAddress1());
		$this->assertEquals("test 2", $address->getAddress2());
		$this->assertEquals("test 3", $address->getAddress3());
		$this->assertEquals("14320", $address->getPostalCode());
		$this->assertEquals("Feuguerolles-Bully", $address->getCity());
	}
}