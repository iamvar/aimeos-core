<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2018
 */


namespace Aimeos\MShop\Coupon\Provider\Decorator;


class OnceTest extends \PHPUnit\Framework\TestCase
{
	private $context;
	private $order;
	private $couponItem;


	protected function setUp()
	{
		$this->context = \TestHelperMShop::getContext();
		$this->couponItem = \Aimeos\MShop::create( $this->context, 'coupon' )->createItem();

		$orderManager = \Aimeos\MShop::create( $this->context, 'order' );
		$search = $orderManager->createSearch();
		$search->setConditions( $search->compare( '==', 'order.price', '4800.00' ) );
		$baskets = $orderManager->searchItems( $search );

		if( ( $basket = reset( $baskets ) ) === false ) {
			throw new \RuntimeException( 'No order with price "4800.00" found' );
		}

		$this->order = $orderManager->load( $basket->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ADDRESS );
	}


	protected function tearDown()
	{
		unset( $this->context, $this->order, $this->couponItem );
	}


	public function testIsAvailable()
	{
		$provider = new \Aimeos\MShop\Coupon\Provider\Example( $this->context, $this->couponItem, 'ABCD' );
		$object = new \Aimeos\MShop\Coupon\Provider\Decorator\Once( $provider, $this->context, $this->couponItem, 'ABCD' );
		$object->setObject( $object );

		$this->assertTrue( $object->isAvailable( $this->order ) );
	}


	public function testIsAvailableExisting()
	{
		$provider = new \Aimeos\MShop\Coupon\Provider\Example( $this->context, $this->couponItem, 'OPQR' );
		$object = new \Aimeos\MShop\Coupon\Provider\Decorator\Once( $provider, $this->context, $this->couponItem, 'OPQR' );
		$object->setObject( $object );

		$this->assertFalse( $object->isAvailable( $this->order ) );
	}
}
