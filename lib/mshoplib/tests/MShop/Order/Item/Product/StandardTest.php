<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MShop\Order\Item\Product;


class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $values;
	private $price;
	private $attribute = [];
	private $subProducts;


	protected function setUp()
	{
		$this->price = \Aimeos\MShop\Price\Manager\Factory::create( \TestHelperMShop::getContext() )->createItem();

		$attrValues = array(
			'order.product.attribute.id' => 4,
			'order.product.attribute.siteid' => 99,
			'order.product.attribute.parentid' => 11,
			'order.product.attribute.type' => 'default',
			'order.product.attribute.code' => 'size',
			'order.product.attribute.value' => '30',
			'order.product.attribute.name' => 'small',
			'order.product.attribute.mtime' => '2011-01-06 13:20:34',
			'order.product.attribute.ctime' => '2011-01-01 00:00:01',
			'order.product.attribute.editor' => 'unitTestUser'
		);
		$this->attribute = array( new \Aimeos\MShop\Order\Item\Product\Attribute\Standard( $attrValues ) );

		$this->values = array(
			'order.product.id' => 1,
			'order.product.siteid' => 99,
			'order.product.orderproductid' => 10,
			'order.product.orderaddressid' => 11,
			'order.product.type' => 'bundle',
			'order.product.productid' => 100,
			'order.product.orderid' => 42,
			'order.product.suppliercode' => 'UnitSupplier',
			'order.product.prodcode' => 'UnitProd',
			'order.product.stocktype' => 'unittype',
			'order.product.timeframe' => '1-2w',
			'order.product.name' => 'UnitProduct',
			'order.product.description' => 'Unit product description',
			'order.product.mediaurl' => 'testurl',
			'order.product.target' => 'testtarget',
			'order.product.quantity' => 11,
			'order.product.flags' => \Aimeos\MShop\Order\Item\Product\Base::FLAG_NONE,
			'order.product.status' => \Aimeos\MShop\Order\Item\Base::STAT_PROGRESS,
			'order.product.position' => 1,
			'order.product.mtime' => '2000-12-31 23:59:59',
			'order.product.ctime' => '2011-01-01 00:00:01',
			'order.product.editor' => 'unitTestUser',
		);

		$this->subProducts = array(
			new \Aimeos\MShop\Order\Item\Product\Standard( clone $this->price ),
			new \Aimeos\MShop\Order\Item\Product\Standard( clone $this->price )
		);
		$this->object = new \Aimeos\MShop\Order\Item\Product\Standard( $this->price, $this->values, $this->attribute, $this->subProducts );
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testCompare()
	{
		$product = new \Aimeos\MShop\Order\Item\Product\Standard( $this->price, $this->values, $this->attribute, $this->subProducts );
		$this->assertTrue( $this->object->compare( $product ) );
	}


	public function testCompareFail()
	{
		$this->values['order.product.stocktype'] = 'default';

		$product = new \Aimeos\MShop\Order\Item\Product\Standard( $this->price, $this->values, $this->attribute, $this->subProducts );
		$this->assertFalse( $this->object->compare( $product ) );
	}


	public function testGetId()
	{
		$this->assertEquals( 1, $this->object->getId() );
	}


	public function testSetId()
	{
		$return = $this->object->setId( null );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( null, $this->object->getId() );
		$this->assertTrue( $this->object->isModified() );

		$return = $this->object->setId( 5 );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 5, $this->object->getId() );
		$this->assertFalse( $this->object->isModified() );
	}


	public function testGetSiteId()
	{
		$this->assertEquals( 99, $this->object->getSiteId() );
	}


	public function testSetSiteId()
	{
		$this->object->setSiteId( 100 );
		$this->assertEquals( 100, $this->object->getSiteId() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetOrderProductId()
	{
		$this->assertEquals( 10, $this->object->getOrderProductId() );
	}


	public function testSetOrderProductId()
	{
		$return = $this->object->setOrderProductId( 1001 );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 1001, $this->object->getOrderProductId() );
		$this->assertTrue( $this->object->isModified() );

		$return = $this->object->setOrderProductId( null );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( null, $this->object->getOrderProductId() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetOrderAddressId()
	{
		$this->assertEquals( 11, $this->object->getOrderAddressId() );
	}


	public function testSetOrderAddressId()
	{
		$return = $this->object->setOrderAddressId( 1011 );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 1011, $this->object->getOrderAddressId() );
		$this->assertTrue( $this->object->isModified() );

		$return = $this->object->setOrderAddressId( null );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( null, $this->object->getOrderAddressId() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetType()
	{
		$this->assertEquals( 'bundle', $this->object->getType() );
	}


	public function testSetType()
	{
		$return = $this->object->setType( 'default' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'default', $this->object->getType() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetSupplierCode()
	{
		$this->assertEquals( 'UnitSupplier', $this->object->getSupplierCode() );
	}


	public function testSetSupplierCode()
	{
		$return = $this->object->setSupplierCode( 'testId' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'testId', $this->object->getSupplierCode() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetProductId()
	{
		$this->assertEquals( 100, $this->object->getProductId() );
	}


	public function testSetProductId()
	{
		$return = $this->object->setProductId( 'testProdId' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'testProdId', $this->object->getProductId() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetProductCode()
	{
		$this->assertEquals( 'UnitProd', $this->object->getProductCode() );
	}


	public function testSetProductCode()
	{
		$return = $this->object->setProductCode( 'testProdCode' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'testProdCode', $this->object->getProductCode() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetStockType()
	{
		$this->assertEquals( 'unittype', $this->object->getStockType() );
	}


	public function testSetStockType()
	{
		$return = $this->object->setStockType( 'testStockType' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'testStockType', $this->object->getStockType() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetName()
	{
		$this->assertEquals( 'UnitProduct', $this->object->getName() );
	}


	public function testSetName()
	{
		$return = $this->object->setName( 'Testname2' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'Testname2', $this->object->getName() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetDescription()
	{
		$this->assertEquals( 'Unit product description', $this->object->getDescription() );
	}


	public function testSetDescription()
	{
		$return = $this->object->setDescription( 'Test description' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'Test description', $this->object->getDescription() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetMediaUrl()
	{
		$this->assertEquals( 'testurl', $this->object->getMediaUrl() );
	}


	public function testSetMediaUrl()
	{
		$return = $this->object->setMediaUrl( 'testUrl' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'testUrl', $this->object->getMediaUrl() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetTarget()
	{
		$this->assertEquals( 'testtarget', $this->object->getTarget() );
	}


	public function testSetTarget()
	{
		$return = $this->object->setTarget( 'ttarget' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'ttarget', $this->object->getTarget() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetTimeFrame()
	{
		$this->assertEquals( '1-2w', $this->object->getTimeFrame() );
	}


	public function testSetTimeFrame()
	{
		$return = $this->object->setTimeFrame( '3-4d' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( '3-4d', $this->object->getTimeFrame() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetQuantity()
	{
		$this->assertEquals( 11, $this->object->getQuantity() );
	}


	public function testSetQuantity()
	{
		$return = $this->object->setQuantity( 20 );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 20, $this->object->getQuantity() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testSetQuantityDecimal()
	{
		$return = $this->object->setQuantity( 1.5 );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 1, $this->object->getQuantity() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testSetQuantityNoNumber()
	{
		$this->setExpectedException( \Aimeos\MShop\Order\Exception::class );
		$this->object->setQuantity( 'a' );
	}


	public function testSetQuantityNegative()
	{
		$this->setExpectedException( \Aimeos\MShop\Order\Exception::class );
		$this->object->setQuantity( -5 );
	}


	public function testSetQuantityZero()
	{
		$this->setExpectedException( \Aimeos\MShop\Order\Exception::class );
		$this->object->setQuantity( 0 );
	}


	public function testSetQuantityOverflow()
	{
		$this->setExpectedException( \Aimeos\MShop\Order\Exception::class );
		$this->object->setQuantity( 2147483648 );
	}


	public function testGetPrice()
	{
		$this->assertSame( $this->price, $this->object->getPrice() );
	}


	public function testSetPrice()
	{
		$this->price->setValue( '5.00' );
		$return = $this->object->setPrice( $this->price );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertSame( $this->price, $this->object->getPrice() );
		$this->assertFalse( $this->object->isModified() );
	}


	public function testGetFlags()
	{
		$this->assertEquals( \Aimeos\MShop\Order\Item\Product\Base::FLAG_NONE, $this->object->getFlags() );
	}


	public function testSetFlags()
	{
		$return = $this->object->setFlags( \Aimeos\MShop\Order\Item\Product\Base::FLAG_IMMUTABLE );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( \Aimeos\MShop\Order\Item\Product\Base::FLAG_IMMUTABLE, $this->object->getFlags() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetPosition()
	{
		$this->assertEquals( 1, $this->object->getPosition() );
	}


	public function testSetPosition()
	{
		$return = $this->object->setPosition( 2 );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 2, $this->object->getPosition() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testSetPositionReset()
	{
		$return = $this->object->setPosition( null );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( null, $this->object->getPosition() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testSetPositionInvalid()
	{
		$this->setExpectedException( \Aimeos\MShop\Order\Exception::class );
		$this->object->setPosition( -1 );
	}


	public function testGetStatus()
	{
		$this->assertEquals( \Aimeos\MShop\Order\Item\Base::STAT_PROGRESS, $this->object->getStatus() );
	}


	public function testSetStatus()
	{
		$return = $this->object->setStatus( \Aimeos\MShop\Order\Item\Base::STAT_LOST );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( \Aimeos\MShop\Order\Item\Base::STAT_LOST, $this->object->getStatus() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetOrderId()
	{
		$this->assertEquals( 42, $this->object->getOrderId() );
	}


	public function testSetOrderId()
	{
		$return = $this->object->setOrderId( 111 );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 111, $this->object->getOrderId() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testSetOrderIdReset()
	{
		$return = $this->object->setOrderId( null );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( null, $this->object->getOrderId() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetTimeModified()
	{
		$regexp = '/^[0-9]{4}-[0-1][0-9]-[0-3][0-9] [0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/';
		$this->assertRegExp( $regexp, $this->object->getTimeModified() );
		$this->assertEquals( '2000-12-31 23:59:59', $this->object->getTimeModified() );
	}


	public function testGetTimeCreated()
	{
		$this->assertEquals( '2011-01-01 00:00:01', $this->object->getTimeCreated() );
	}


	public function testGetEditor()
	{
		$this->assertEquals( 'unitTestUser', $this->object->getEditor() );
	}


	public function testGetAttribute()
	{
		$manager = \Aimeos\MShop\Order\Manager\Factory::create( \TestHelperMShop::getContext() );
		$attManager = $manager->getSubManager( 'product' )->getSubManager( 'attribute' );

		$attrItem001 = $attManager->createItem();
		$attrItem001->setAttributeId( '1' );
		$attrItem001->setCode( 'code_001' );
		$attrItem001->setValue( 'value_001' );

		$attrItem002 = $attManager->createItem();
		$attrItem002->setAttributeId( '2' );
		$attrItem002->setCode( 'code_002' );
		$attrItem002->setType( 'test_002' );
		$attrItem002->setValue( 'value_002' );

		$this->object->setAttributeItems( array( $attrItem001, $attrItem002 ) );

		$result = $this->object->getAttribute( 'code_001' );
		$this->assertEquals( 'value_001', $result );

		$result = $this->object->getAttribute( 'code_002', ['test_002'] );
		$this->assertEquals( 'value_002', $result );

		$result = $this->object->getAttribute( 'code_002', 'test_002' );
		$this->assertEquals( 'value_002', $result );

		$result = $this->object->getAttribute( 'code_002' );
		$this->assertEquals( null, $result );

		$result = $this->object->getAttribute( 'code_003' );
		$this->assertEquals( null, $result );

		$this->object->setAttributeItems( [] );

		$result = $this->object->getAttribute( 'code_001' );
		$this->assertEquals( null, $result );
	}


	public function testGetAttributeList()
	{
		$manager = \Aimeos\MShop\Order\Manager\Factory::create( \TestHelperMShop::getContext() );
		$attManager = $manager->getSubManager( 'product' )->getSubManager( 'attribute' );

		$attrItem001 = $attManager->createItem();
		$attrItem001->setAttributeId( '1' );
		$attrItem001->setCode( 'code_001' );
		$attrItem001->setType( 'test_001' );
		$attrItem001->setValue( 'value_001' );

		$attrItem002 = $attManager->createItem();
		$attrItem002->setAttributeId( '2' );
		$attrItem002->setCode( 'code_001' );
		$attrItem002->setType( 'test_001' );
		$attrItem002->setValue( 'value_002' );

		$this->object->setAttributeItems( array( $attrItem001, $attrItem002 ) );

		$result = $this->object->getAttribute( 'code_001', 'test_001' );
		$this->assertEquals( ['value_001', 'value_002'], $result );
	}


	public function testGetAttributeItem()
	{
		$manager = \Aimeos\MShop\Order\Manager\Factory::create( \TestHelperMShop::getContext() );
		$attManager = $manager->getSubManager( 'product' )->getSubManager( 'attribute' );

		$attrItem001 = $attManager->createItem();
		$attrItem001->setAttributeId( '1' );
		$attrItem001->setCode( 'code_001' );
		$attrItem001->setValue( 'value_001' );

		$attrItem002 = $attManager->createItem();
		$attrItem002->setAttributeId( '2' );
		$attrItem002->setCode( 'code_002' );
		$attrItem002->setType( 'test_002' );
		$attrItem002->setValue( 'value_002' );

		$this->object->setAttributeItems( array( $attrItem001, $attrItem002 ) );

		$result = $this->object->getAttributeItem( 'code_001' );
		$this->assertEquals( 'value_001', $result->getValue() );

		$result = $this->object->getAttributeItem( 'code_002', 'test_002' );
		$this->assertEquals( 'value_002', $result->getValue() );

		$result = $this->object->getAttributeItem( 'code_002' );
		$this->assertEquals( null, $result );

		$result = $this->object->getAttribute( 'code_003' );
		$this->assertEquals( null, $result );

		$this->object->setAttributeItems( [] );

		$result = $this->object->getAttribute( 'code_001' );
		$this->assertEquals( null, $result );
	}


	public function testGetAttributeItemList()
	{
		$manager = \Aimeos\MShop\Order\Manager\Factory::create( \TestHelperMShop::getContext() );
		$attManager = $manager->getSubManager( 'product' )->getSubManager( 'attribute' );

		$attrItem001 = $attManager->createItem();
		$attrItem001->setAttributeId( '1' );
		$attrItem001->setCode( 'code_001' );
		$attrItem001->setType( 'test_001' );
		$attrItem001->setValue( 'value_001' );

		$attrItem002 = $attManager->createItem();
		$attrItem002->setAttributeId( '2' );
		$attrItem002->setCode( 'code_001' );
		$attrItem002->setType( 'test_001' );
		$attrItem002->setValue( 'value_002' );

		$this->object->setAttributeItems( array( $attrItem001, $attrItem002 ) );

		$result = $this->object->getAttributeItem( 'code_001', 'test_001' );
		$this->assertEquals( 2, count( $result ) );
	}


	public function testGetAttributeItems()
	{
		$this->assertEquals( $this->attribute, $this->object->getAttributeItems() );
	}


	public function testGetAttributeItemsByType()
	{
		$this->assertEquals( $this->attribute, $this->object->getAttributeItems( 'default' ) );
	}


	public function testGetAttributeItemsInvalidType()
	{
		$this->assertEquals( [], $this->object->getAttributeItems( 'invalid' ) );
	}


	public function testSetAttributeItem()
	{
		$manager = \Aimeos\MShop\Order\Manager\Factory::create( \TestHelperMShop::getContext() );
		$attManager = $manager->getSubManager( 'product' )->getSubManager( 'attribute' );

		$item = $attManager->createItem();
		$item->setAttributeId( '1' );
		$item->setCode( 'test_code' );
		$item->setType( 'test_type' );
		$item->setValue( 'test_value' );

		$return = $this->object->setAttributeItem( $item );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'test_value', $this->object->getAttributeItem( 'test_code', 'test_type' )->getValue() );
		$this->assertTrue( $this->object->isModified() );


		$item = $attManager->createItem();
		$item->setAttributeId( '1' );
		$item->setCode( 'test_code' );
		$item->setType( 'test_type' );
		$item->setValue( 'test_value2' );

		$return = $this->object->setAttributeItem( $item );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'test_value2', $this->object->getAttributeItem( 'test_code', 'test_type' )->getValue() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testSetAttributeItems()
	{
		$manager = \Aimeos\MShop\Order\Manager\Factory::create( \TestHelperMShop::getContext() );
		$attManager = $manager->getSubManager( 'product' )->getSubManager( 'attribute' );

		$list = array(
			$attManager->createItem(),
			$attManager->createItem(),
		);

		$return = $this->object->setAttributeItems( $list );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( $list, $this->object->getAttributeItems() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetProducts()
	{
		$this->assertEquals( $this->subProducts, $this->object->getProducts() );
	}


	public function testSetProducts()
	{
		$return = $this->object->setProducts( [] );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( [], $this->object->getProducts() );

		$return = $this->object->setProducts( $this->subProducts );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( $this->subProducts, $this->object->getProducts() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetResourceType()
	{
		$this->assertEquals( 'order/product', $this->object->getResourceType() );
	}


	public function testFromArray()
	{
		$item = new \Aimeos\MShop\Order\Item\Product\Standard( new \Aimeos\MShop\Price\Item\Standard() );

		$list = $entries = array(
			'order.product.id' => 1,
			'order.product.orderid' => 2,
			'order.product.siteid' => 123,
			'order.product.orderproductid' => 10,
			'order.product.orderaddressid' => 11,
			'order.product.productid' => 3,
			'order.product.prodcode' => 'test',
			'order.product.name' => 'test item',
			'order.product.description' => 'test description',
			'order.product.stocktype' => 'stocktype',
			'order.product.suppliercode' => 'testsup',
			'order.product.prodcode' => 'test',
			'order.product.mediaurl' => '/path/to/image.jpg',
			'order.product.target' => 'ttarget',
			'order.product.timeframe' => '1-2d',
			'order.product.position' => 4,
			'order.product.quantity' => 5,
			'order.product.status' => 0,
			'order.product.flags' => 1,
			'order.product.price' => '10.00',
			'order.product.costs' => '5.00',
			'order.product.rebate' => '2.00',
			'order.product.taxrate' => '20.00',
		);

		$item = $item->fromArray( $entries, true );

		$this->assertEquals( [], $entries );
		$this->assertEquals( $list['order.product.id'], $item->getId() );
		$this->assertEquals( $list['order.product.orderid'], $item->getOrderId() );
		$this->assertEquals( $list['order.product.siteid'], $item->getSiteId() );
		$this->assertEquals( $list['order.product.orderproductid'], $item->getOrderProductId() );
		$this->assertEquals( $list['order.product.orderaddressid'], $item->getOrderAddressId() );
		$this->assertEquals( $list['order.product.productid'], $item->getProductId() );
		$this->assertEquals( $list['order.product.prodcode'], $item->getProductCode() );
		$this->assertEquals( $list['order.product.name'], $item->getName() );
		$this->assertEquals( $list['order.product.description'], $item->getDescription() );
		$this->assertEquals( $list['order.product.stocktype'], $item->getStockType() );
		$this->assertEquals( $list['order.product.suppliercode'], $item->getSupplierCode() );
		$this->assertEquals( $list['order.product.prodcode'], $item->getProductCode() );
		$this->assertEquals( $list['order.product.mediaurl'], $item->getMediaUrl() );
		$this->assertEquals( $list['order.product.timeframe'], $item->getTimeFrame() );
		$this->assertEquals( $list['order.product.target'], $item->getTarget() );
		$this->assertEquals( $list['order.product.position'], $item->getPosition() );
		$this->assertEquals( $list['order.product.quantity'], $item->getQuantity() );
		$this->assertEquals( $list['order.product.status'], $item->getStatus() );
		$this->assertEquals( $list['order.product.flags'], $item->getFlags() );
		$this->assertEquals( $list['order.product.price'], $item->getPrice()->getValue() );
		$this->assertEquals( $list['order.product.costs'], $item->getPrice()->getCosts() );
		$this->assertEquals( $list['order.product.rebate'], $item->getPrice()->getRebate() );
		$this->assertEquals( $list['order.product.taxrate'], $item->getPrice()->getTaxRate() );
	}


	public function testToArray()
	{
		$arrayObject = $this->object->toArray( true );

		$this->assertEquals( $this->object->getId(), $arrayObject['order.product.id'] );
		$this->assertEquals( $this->object->getSiteId(), $arrayObject['order.product.siteid'] );
		$this->assertEquals( $this->object->getOrderId(), $arrayObject['order.product.orderid'] );
		$this->assertEquals( $this->object->getOrderProductId(), $arrayObject['order.product.orderproductid'] );
		$this->assertEquals( $this->object->getOrderAddressId(), $arrayObject['order.product.orderaddressid'] );
		$this->assertEquals( $this->object->getStockType(), $arrayObject['order.product.stocktype'] );
		$this->assertEquals( $this->object->getSupplierCode(), $arrayObject['order.product.suppliercode'] );
		$this->assertEquals( $this->object->getProductId(), $arrayObject['order.product.productid'] );
		$this->assertEquals( $this->object->getProductCode(), $arrayObject['order.product.prodcode'] );
		$this->assertEquals( $this->object->getName(), $arrayObject['order.product.name'] );
		$this->assertEquals( $this->object->getDescription(), $arrayObject['order.product.description'] );
		$this->assertEquals( $this->object->getMediaUrl(), $arrayObject['order.product.mediaurl'] );
		$this->assertEquals( $this->object->getTimeFrame(), $arrayObject['order.product.timeframe'] );
		$this->assertEquals( $this->object->getTarget(), $arrayObject['order.product.target'] );
		$this->assertEquals( $this->object->getPosition(), $arrayObject['order.product.position'] );
		$this->assertEquals( $this->object->getPrice()->getValue(), $arrayObject['order.product.price'] );
		$this->assertEquals( $this->object->getPrice()->getCosts(), $arrayObject['order.product.costs'] );
		$this->assertEquals( $this->object->getPrice()->getRebate(), $arrayObject['order.product.rebate'] );
		$this->assertEquals( $this->object->getPrice()->getTaxRate(), $arrayObject['order.product.taxrate'] );
		$this->assertEquals( $this->object->getQuantity(), $arrayObject['order.product.quantity'] );
		$this->assertEquals( $this->object->getStatus(), $arrayObject['order.product.status'] );
		$this->assertEquals( $this->object->getFlags(), $arrayObject['order.product.flags'] );
		$this->assertEquals( $this->object->getTimeModified(), $arrayObject['order.product.mtime'] );
		$this->assertEquals( $this->object->getTimeCreated(), $arrayObject['order.product.ctime'] );
		$this->assertEquals( $this->object->getTimeModified(), $arrayObject['order.product.mtime'] );
		$this->assertEquals( $this->object->getEditor(), $arrayObject['order.product.editor'] );
	}


	public function testIsModified()
	{
		$this->assertFalse( $this->object->isModified() );
	}


	public function testCopyFrom()
	{
		$productCopy = new \Aimeos\MShop\Order\Item\Product\Standard( $this->price );

		$manager = \Aimeos\MShop\Product\Manager\Factory::create( \TestHelperMShop::getContext() );
		$search = $manager->createSearch();
		$search->setConditions( $search->compare( '==', 'product.code', 'CNE' ) );
		$products = $manager->searchItems( $search, ['text'] );

		if( ( $product = reset( $products ) ) === false ) {
			throw new \RuntimeException( 'No product found' );
		}

		$return = $productCopy->copyFrom( $product );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $return );
		$this->assertEquals( 'default', $productCopy->getType() );
		$this->assertEquals( 'CNE', $productCopy->getProductCode() );
		$this->assertEquals( 'Cafe Noire Expresso', $productCopy->getName() );
		$this->assertEquals( 'Cafe Noire Expresso for basket', $productCopy->getDescription() );
		$this->assertEquals( $product->getId(), $productCopy->getProductId() );
		$this->assertEquals( \Aimeos\MShop\Order\Item\Base::STAT_UNFINISHED, $productCopy->getStatus() );
		$this->assertEquals( '', $productCopy->getSupplierCode() );
		$this->assertEquals( '', $productCopy->getMediaUrl() );
		$this->assertEquals( '', $productCopy->getTarget() );

		$this->assertTrue( $productCopy->isModified() );
	}
}
