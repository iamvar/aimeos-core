<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019
 */


namespace Aimeos\MShop\Coupon\Provider\Decorator;


class NotTest extends \PHPUnit\Framework\TestCase
{
	private $provider;
	private $object;
	private $order;


	protected function setUp()
	{
		$context = \TestHelperMShop::getContext();
		$item = \Aimeos\MShop\Coupon\Manager\Factory::create( $context )->createItem();

		$this->order = \Aimeos\MShop\Order\Manager\Factory::create( $context )->createItem()->off();

		$this->provider = $this->getMockBuilder( \Aimeos\MShop\Coupon\Provider\Example::class )
			->setConstructorArgs( [$context, $item, 'abcd'] )
			->setMethods( ['isAvailable'] )
			->getMock();

		$this->object = new \Aimeos\MShop\Coupon\Provider\Decorator\Not( $this->provider, $context, $item, 'abcd' );
	}


	protected function tearDown()
	{
		unset( $this->object, $this->provider, $this->order );
	}


	public function testIsAvailableFalse()
	{
		$this->provider->expects( $this->once() )->method( 'isAvailable' )->will( $this->returnValue( true ) );
		$this->assertFalse( $this->object->isAvailable( $this->order ) );
	}


	public function testIsAvailableTrue()
	{
		$this->provider->expects( $this->once() )->method( 'isAvailable' )->will( $this->returnValue( false ) );
		$this->assertTrue( $this->object->isAvailable( $this->order ) );
	}
}
