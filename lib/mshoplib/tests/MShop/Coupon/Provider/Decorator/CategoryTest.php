<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2018
 */


namespace Aimeos\MShop\Coupon\Provider\Decorator;


class CategoryTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $context;
	private $order;
	private $couponItem;


	protected function setUp()
	{
		$this->context = \TestHelperMShop::getContext();
		$this->couponItem = \Aimeos\MShop\Coupon\Manager\Factory::create( $this->context )->createItem();

		$provider = new \Aimeos\MShop\Coupon\Provider\Example( $this->context, $this->couponItem, 'abcd' );
		$this->object = new \Aimeos\MShop\Coupon\Provider\Decorator\Category( $provider, $this->context, $this->couponItem, 'abcd' );
		$this->object->setObject( $this->object );

		$priceManager = \Aimeos\MShop::create( $this->context, 'price' );
		$productManager = \Aimeos\MShop::create( $this->context, 'product' );
		$product = $productManager->findItem( 'CNE' );

		$orderProductManager = \Aimeos\MShop::create( $this->context, 'order/product' );
		$orderProduct = $orderProductManager->createItem();
		$orderProduct->copyFrom( $product );

		$this->order = new \Aimeos\MShop\Order\Item\Standard( $priceManager->createItem(), $this->context->getLocale() );
		$this->order->addProduct( $orderProduct );
	}


	protected function tearDown()
	{
		unset( $this->object );
		unset( $this->order );
		unset( $this->couponItem );
	}


	public function testGetConfigBE()
	{
		$result = $this->object->getConfigBE();

		$this->assertArrayHasKey( 'category.code', $result );
	}


	public function testCheckConfigBE()
	{
		$attributes = ['category.code' => 'test'];
		$result = $this->object->checkConfigBE( $attributes );

		$this->assertEquals( 1, count( $result ) );
		$this->assertInternalType( 'null', $result['category.code'] );
	}


	public function testCheckConfigBEFailure()
	{
		$result = $this->object->checkConfigBE( [] );

		$this->assertEquals( 1, count( $result ) );
		$this->assertInternalType( 'string', $result['category.code'] );
	}


	public function testIsAvailable()
	{
		$this->assertTrue( $this->object->isAvailable( $this->order ) );
	}


	public function testIsAvailableWithProduct()
	{
		$this->couponItem->setConfig( array( 'category.code' => 'cafe' ) );

		$this->assertTrue( $this->object->isAvailable( $this->order ) );
	}


	public function testIsAvailableWithoutProduct()
	{
		$this->couponItem->setConfig( array( 'category.code' => 'tea' ) );

		$this->assertFalse( $this->object->isAvailable( $this->order ) );
	}
}
