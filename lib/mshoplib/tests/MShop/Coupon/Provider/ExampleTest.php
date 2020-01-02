<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2017-2018
 */


namespace Aimeos\MShop\Coupon\Provider;


class ExampleTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $order;


	protected function setUp()
	{
		$context = \TestHelperMShop::getContext();
		$priceManager = \Aimeos\MShop\Price\Manager\Factory::create( $context );
		$item = \Aimeos\MShop\Coupon\Manager\Factory::create( $context )->createItem();

		// Don't create order item by createItem() as this would already register the plugins
		$this->order = new \Aimeos\MShop\Order\Item\Standard( $priceManager->createItem(), $context->getLocale() );
		$this->object = new \Aimeos\MShop\Coupon\Provider\Example( $context, $item, '90AB' );
	}


	protected function tearDown()
	{
		unset( $this->object, $this->order );
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
