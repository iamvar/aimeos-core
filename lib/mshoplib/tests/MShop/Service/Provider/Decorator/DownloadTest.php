<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MShop\Service\Provider\Decorator;


class DownloadTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $context;
	private $servItem;
	private $mockProvider;


	protected function setUp()
	{
		$this->context = \TestHelperMShop::getContext();

		$servManager = \Aimeos\MShop\Service\Manager\Factory::create( $this->context );
		$this->servItem = $servManager->createItem();

		$this->mockProvider = $this->getMockBuilder( \Aimeos\MShop\Service\Provider\Decorator\Example::class )
			->disableOriginalConstructor()->getMock();

		$this->object = new \Aimeos\MShop\Service\Provider\Decorator\Download( $this->mockProvider, $this->context, $this->servItem );
	}


	protected function tearDown()
	{
		\Aimeos\MShop\Order\Manager\Factory::injectManager( '\Aimeos\MShop\Order\Manager\StandardMock', null );
	}


	public function testGetConfigBE()
	{
		$this->mockProvider->expects( $this->once() )->method( 'getConfigBE' )->will( $this->returnValue( [] ) );

		$result = $this->object->getConfigBE();

		$this->assertArrayHasKey( 'download.all', $result );
	}


	public function testCheckConfigBEOK()
	{
		$this->mockProvider->expects( $this->once() )
			->method( 'checkConfigBE' )
			->will( $this->returnValue( [] ) );

		$attributes = array( 'download.all' => '1' );
		$result = $this->object->checkConfigBE( $attributes );

		$this->assertEquals( 1, count( $result ) );
		$this->assertInternalType( 'null', $result['download.all'] );
	}


	public function testCheckConfigBEFailure()
	{
		$this->mockProvider->expects( $this->once() )
			->method( 'checkConfigBE' )
			->will( $this->returnValue( [] ) );

		$attributes = array( 'download.all' => [] );
		$result = $this->object->checkConfigBE( $attributes );

		$this->assertEquals( 1, count( $result ) );
		$this->assertInternalType( 'string', $result['download.all'] );
	}


	public function testIsAvailableNoConfig()
	{
		$this->mockProvider->expects( $this->once() )
			->method( 'isAvailable' )
			->will( $this->returnValue( true ) );

		$this->assertTrue( $this->object->isAvailable( $this->getOrderItem() ) );
	}


	public function testIsAvailableOK()
	{
		$this->servItem->setConfig( array( 'download.all' => '0' ) );

		$this->mockProvider->expects( $this->once() )
			->method( 'isAvailable' )
			->will( $this->returnValue( true ) );

		$this->assertTrue( $this->object->isAvailable( $this->getOrderItem() ) );
	}


	public function testIsAvailableFailure()
	{
		$this->servItem->setConfig( array( 'download.all' => '1' ) );

		$this->assertFalse( $this->object->isAvailable( $this->getOrderItem() ) );
	}


	public function testIsAvailableFailureNoArticle()
	{
		$manager = \Aimeos\MShop::create( $this->context, 'order' );
		$this->servItem->setConfig( array( 'download.all' => '0' ) );

		$this->assertFalse( $this->object->isAvailable( $manager->createItem() ) );
	}


	/**
	 * Returns an order item
	 *
	 * @return \Aimeos\MShop\Order\Item\Iface Order item
	 */
	protected function getOrderItem()
	{
		$manager = \Aimeos\MShop::create( $this->context, 'order' );

		$search = $manager->createSearch();
		$search->setConditions( $search->compare( '==', 'order.datepayment', '2008-02-15 12:34:56' ) );
		$result = $manager->searchItems( $search, ['order/product'] );

		if( ( $item = reset( $result ) ) === false ) {
			throw new \RuntimeException( 'No order item found' );
		}

		return $item;
	}
}
