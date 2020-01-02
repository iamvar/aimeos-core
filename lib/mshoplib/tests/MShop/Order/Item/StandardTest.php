<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MShop\Order\Item;


class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $locale;
	private $values;
	private $price;


	protected function setUp()
	{
		$context = \TestHelperMShop::getContext();

		$this->values = array(
			'order.id' => 15,
			'order.siteid' => 99,
			'order.type' => \Aimeos\MShop\Order\Item\Base::TYPE_WEB,
			'order.statusdelivery' => \Aimeos\MShop\Order\Item\Base::STAT_PENDING,
			'order.statuspayment' => \Aimeos\MShop\Order\Item\Base::PAY_RECEIVED,
			'order.datepayment' => '2004-12-01 12:34:56',
			'order.datedelivery' => '2004-01-03 12:34:56',
			'order.relatedid' => 1,
			'order.customerid' => 'testuser',
			'order.customerref' => 'ABC-1234',
			'order.comment' => 'this is a comment from unittest',
			'order.mtime' => '2011-01-01 00:00:02',
			'order.ctime' => '2011-01-01 00:00:01',
			'order.editor' => 'unitTestUser'
		);

		$this->price = \Aimeos\MShop\Price\Manager\Factory::create( $context )->createItem();
		$this->locale = \Aimeos\MShop\Locale\Manager\Factory::create( $context )->createItem();
		$this->object = new \Aimeos\MShop\Order\Item\Standard( $this->price, $this->locale, $this->values );
	}


	protected function tearDown()
	{
		unset( $this->object, $this->locale, $this->price );
	}


	public function testGetId()
	{
		$this->assertEquals( $this->values['order.id'], $this->object->getId() );
	}


	public function testSetId()
	{
		$return = $this->object->setId( null );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( null, $this->object->getId() );
		$this->assertTrue( $this->object->isModified() );

		$return = $this->object->setId( 15 );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( 15, $this->object->getId() );
		$this->assertFalse( $this->object->isModified() );
	}


	public function testGetSiteId()
	{
		$this->assertEquals( 99, $this->object->getSiteId() );
	}


	public function testGetType()
	{
		$this->assertEquals( $this->values['order.type'], $this->object->getType() );
	}


	public function testSetType()
	{
		$return = $this->object->setType( \Aimeos\MShop\Order\Item\Base::TYPE_PHONE );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( \Aimeos\MShop\Order\Item\Base::TYPE_PHONE, $this->object->getType() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetDateDelivery()
	{
		$this->assertEquals( $this->values['order.datedelivery'], $this->object->getDateDelivery() );
	}


	public function testSetDateDelivery()
	{
		$return = $this->object->setDateDelivery( '2008-04-12 12:34:56' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( '2008-04-12 12:34:56', $this->object->getDateDelivery() );
		$this->assertTrue( $this->object->isModified() );

		$this->setExpectedException( \Aimeos\MShop\Exception::class );
		$this->object->setDateDelivery( '2008-34-12' );
	}


	public function testGetDatePayment()
	{
		$this->assertEquals( $this->values['order.datepayment'], $this->object->getDatePayment() );
	}


	public function testSetDatePayment()
	{
		$return = $this->object->setDatePayment( '2008-04-12 12:34:56' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( '2008-04-12 12:34:56', $this->object->getDatePayment() );
		$this->assertTrue( $this->object->isModified() );

		$this->setExpectedException( \Aimeos\MShop\Exception::class );
		$this->object->setDatePayment( '2008-34-12' );
	}


	public function testGetDeliveryStatus()
	{
		$this->assertEquals( $this->values['order.statusdelivery'], $this->object->getDeliveryStatus() );
	}


	public function testSetDeliveryStatus()
	{
		$return = $this->object->setDeliveryStatus( \Aimeos\MShop\Order\Item\Base::STAT_PROGRESS );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( \Aimeos\MShop\Order\Item\Base::STAT_PROGRESS, $this->object->getDeliveryStatus() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetPaymentStatus()
	{
		$this->assertEquals( $this->values['order.statuspayment'], $this->object->getPaymentStatus() );
	}


	public function testSetPaymentStatus()
	{
		$return = $this->object->setPaymentStatus( \Aimeos\MShop\Order\Item\Base::PAY_DELETED );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( \Aimeos\MShop\Order\Item\Base::PAY_DELETED, $this->object->getPaymentStatus() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetRelatedId()
	{
		$this->assertEquals( $this->values['order.relatedid'], $this->object->getRelatedId() );
	}


	public function testSetRelatedId()
	{
		$return = $this->object->setRelatedId( 22 );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( 22, $this->object->getRelatedId() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetCustomerId()
	{
		$this->assertEquals( 'testuser', $this->object->getCustomerId() );
	}


	public function testSetCustomerId()
	{
		$return = $this->object->setCustomerId( '44' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( '44', $this->object->getCustomerId() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetCustomerReference()
	{
		$this->assertEquals( 'ABC-1234', $this->object->getCustomerReference() );
	}


	public function testSetCustomerReference()
	{
		$return = $this->object->setCustomerReference( 'XYZ-9876' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( 'XYZ-9876', $this->object->getCustomerReference() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetLocale()
	{
		$this->assertEquals( $this->locale, $this->object->getLocale() );
	}


	public function testSetLocale()
	{
		$locale = \Aimeos\MShop\Locale\Manager\Factory::create( \TestHelperMShop::getContext() )->createItem();
		$return = $this->object->setLocale( $locale );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( $locale, $this->object->getLocale() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetPrice()
	{
		$priceItem = $this->object->getPrice();

		$this->assertEquals( $priceItem->getCurrencyId(), 'EUR' );
		$this->assertEquals( $priceItem->getTaxRate(), '0.00' );
		$this->assertEquals( $priceItem->getRebate(), '0.00' );
		$this->assertEquals( $priceItem->getCosts(), '0.00' );
		$this->assertEquals( $priceItem->getValue(), '0.00' );
	}


	public function testGetComment()
	{
		$this->assertEquals( 'this is a comment from unittest', $this->object->getComment() );
	}


	public function testSetComment()
	{
		$return = $this->object->setComment( 'New unit test comment' );

		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $return );
		$this->assertEquals( 'New unit test comment', $this->object->getComment() );
		$this->assertTrue( $this->object->isModified() );
	}


	public function testGetTimeModified()
	{
		$this->assertEquals( '2011-01-01 00:00:02', $this->object->getTimeModified() );
	}


	public function testGetTimeCreated()
	{
		$this->assertEquals( '2011-01-01 00:00:01', $this->object->getTimeCreated() );
	}


	public function testGetEditor()
	{
		$this->assertEquals( 'unitTestUser', $this->object->getEditor() );
	}


	public function testGetResourceType()
	{
		$this->assertEquals( 'order', $this->object->getResourceType() );
	}


	public function testFromArray()
	{
		$item = new \Aimeos\MShop\Order\Item\Standard( $this->price, $this->locale );

		$list = $entries = array(
			'order.id' => 1,
			'order.type' => \Aimeos\MShop\Order\Item\Base::TYPE_WEB,
			'order.relatedid' => 3,
			'order.statusdelivery' => 4,
			'order.statuspayment' => 5,
			'order.customerref' => 'testref',
			'order.comment' => 'test comment',
			'order.languageid' => 'de',
			'order.customerid' => 3,
			'order.datepayment' => '2000-01-01 00:00:00',
			'order.datedelivery' => '2001-01-01 00:00:00',
		);

		$item = $item->fromArray( $entries, true );

		$this->assertEquals( [], $entries );
		$this->assertEquals( $list['order.id'], $item->getId() );
		$this->assertEquals( $list['order.type'], $item->getType() );
		$this->assertEquals( $list['order.relatedid'], $item->getRelatedId() );
		$this->assertEquals( $list['order.statusdelivery'], $item->getDeliveryStatus() );
		$this->assertEquals( $list['order.statuspayment'], $item->getPaymentStatus() );
		$this->assertEquals( $list['order.datepayment'], $item->getDatePayment() );
		$this->assertEquals( $list['order.datedelivery'], $item->getDateDelivery() );
		$this->assertEquals( $list['order.customerid'], $item->getCustomerId() );
		$this->assertEquals( $list['order.languageid'], $item->getLocale()->getLanguageId() );
		$this->assertEquals( $list['order.customerref'], $item->getCustomerReference() );
		$this->assertEquals( $list['order.comment'], $item->getComment() );
	}


	public function testToArray()
	{
		$list = $this->object->toArray( true );
		$this->assertEquals( count( $this->values ), count( $list ) );

		$this->assertEquals( $this->object->getId(), $list['order.id'] );
		$this->assertEquals( $this->object->getSiteId(), $list['order.siteid'] );
		$this->assertEquals( $this->object->getType(), $list['order.type'] );
		$this->assertEquals( $this->object->getDeliveryStatus(), $list['order.statusdelivery'] );
		$this->assertEquals( $this->object->getPaymentStatus(), $list['order.statuspayment'] );
		$this->assertEquals( $this->object->getDatePayment(), $list['order.datepayment'] );
		$this->assertEquals( $this->object->getDateDelivery(), $list['order.datedelivery'] );
		$this->assertEquals( $this->object->getRelatedId(), $list['order.relatedid'] );
		$this->assertEquals( $this->object->getCustomerId(), $list['order.customerid'] );
		$this->assertEquals( $this->object->getLocale()->getLanguageId(), $list['order.languageid'] );
		$this->assertEquals( $this->object->getCustomerReference(), $list['order.customerref'] );
		$this->assertEquals( $this->object->getComment(), $list['order.comment'] );
		$this->assertEquals( $this->object->getTimeModified(), $list['order.mtime'] );
		$this->assertEquals( $this->object->getTimeCreated(), $list['order.ctime'] );
		$this->assertEquals( $this->object->getEditor(), $list['order.editor'] );

		$this->assertEquals( $price->getValue(), $list['order.price'] );
		$this->assertEquals( $price->getCosts(), $list['order.costs'] );
		$this->assertEquals( $price->getRebate(), $list['order.rebate'] );
		$this->assertEquals( $price->getCurrencyId(), $list['order.currencyid'] );
	}


	public function testIsModified()
	{
		$this->assertFalse( $this->object->isModified() );
	}
}
