<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2018
 */


namespace Aimeos\MShop\Coupon\Provider;


class NoneTest extends \PHPUnit\Framework\TestCase
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
		$this->object = new \Aimeos\MShop\Coupon\Provider\None( $context, $item, '1234' );
	}


	protected function tearDown()
	{
		unset( $this->object );
		unset( $this->order );
	}


	public function testUpdate()
	{
		$this->object->update( $this->order );
	}
}
