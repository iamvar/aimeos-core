<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2017-2018
 */

namespace Aimeos\MShop\Coupon\Provider\Decorator;


class ExampleTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $order;


	protected function setUp()
	{
		$context = \TestHelperMShop::getContext();
		$item = \Aimeos\MShop\Coupon\Manager\Factory::create( $context )->createItem();

		$this->order = \Aimeos\MShop\Order\Manager\Factory::create( $context )->createItem()->off();

		$provider = new \Aimeos\MShop\Coupon\Provider\Example( $context, $item, 'abcd' );
		$this->object = new \Aimeos\MShop\Coupon\Provider\Decorator\Example( $provider, $context, $item, 'abcd' );
		$this->object->setObject( $this->object );
	}


	protected function tearDown()
	{
		unset( $this->object );
		unset( $this->order );
	}


	public function testIsAvailable()
	{
		$this->assertTrue( $this->object->isAvailable( $this->order ) );
	}


	public function testSetObject()
	{
		$this->object->setObject( $this->object );
	}


	public function testUpdate()
	{
		$this->object->update( $this->order );
	}
}
