<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MShop\Order\Manager;


class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $context;
	private $object;
	private $editor = '';


	protected function setUp()
	{
		$this->editor = \TestHelperMShop::getContext()->getEditor();
		$this->context = \TestHelperMShop::getContext();
		$this->object = new \Aimeos\MShop\Order\Manager\Standard( $this->context );
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testAggregate()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'order.editor', 'core:lib/mshoplib' ) );
		$result = $this->object->aggregate( $search, 'order.type' );

		$this->assertEquals( 2, count( $result ) );
		$this->assertArrayHasKey( 'web', $result );
		$this->assertEquals( 3, $result['web'] );
	}


	public function testAggregateAvg()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'order.editor', 'core:lib/mshoplib' ) );
		$result = $this->object->aggregate( $search, 'order.cmonth', 'order.price', 'avg' );

		$this->assertEquals( 1, count( $result ) );
		$this->assertEquals( '1384.75', round( reset( $result ), 2 ) );
	}


	public function testAggregateSum()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'order.editor', 'core:lib/mshoplib' ) );
		$result = $this->object->aggregate( $search, 'order.cmonth', 'order.price', 'sum' );

		$this->assertEquals( 1, count( $result ) );
		$this->assertEquals( '5539.00', reset( $result ) );
	}


	public function testAggregateTimes()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'order.editor', 'core:lib/mshoplib' ) );
		$search->setSortations( array( $search->sort( '-', 'order.cdate' ) ) );
		$result = $this->object->aggregate( $search, 'order.cmonth' );

		$this->assertEquals( 1, count( $result ) );
		$this->assertEquals( 4, reset( $result ) );
	}


	public function testAggregateType()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'order.editor', 'core:lib/mshoplib' ) );
		$result = $this->object->aggregate( $search, 'order.type' );

		$this->assertEquals( 2, count( $result ) );
		$this->assertArrayHasKey( 'web', $result );
		$this->assertEquals( 3, $result['web'] );
	}


	public function testAggregateAddress()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'order.editor', 'core:lib/mshoplib' ) );
		$result = $this->object->aggregate( $search, 'order.address.countryid' );

		$this->assertEquals( 1, count( $result ) );
		$this->assertArrayHasKey( 'DE', $result );
		$this->assertEquals( 7, reset( $result ) );
	}


	public function testClear()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->clear( [-1] ) );
	}


	public function testDeleteItems()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->deleteItems( [-1] ) );
	}


	public function testGetResourceType()
	{
		$result = $this->object->getResourceType();

		$this->assertContains( 'order', $result );
		$this->assertContains( 'order/status', $result );
		$this->assertContains( 'order/address', $result );
		$this->assertContains( 'order/coupon', $result );
		$this->assertContains( 'order/product', $result );
		$this->assertContains( 'order/product/attribute', $result );
		$this->assertContains( 'order/service', $result );
		$this->assertContains( 'order/service/attribute', $result );
	}


	public function testCreateItem()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Iface::class, $this->object->createItem() );
	}


	public function testGetItem()
	{
		$status = \Aimeos\MShop\Order\Item\Base::PAY_RECEIVED;

		$search = $this->object->createSearch()->setSlice( 0, 1 );
		$conditions = array(
			$search->compare( '==', 'order.statuspayment', $status ),
			$search->compare( '==', 'order.editor', $this->editor )
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$results = $this->object->searchItems( $search );

		if( ( $expected = reset( $results ) ) === false ) {
			throw new \RuntimeException( sprintf( 'No order found in shop_order_invoice with statuspayment "%1$s"', $status ) );
		}

		$actual = $this->object->getItem( $expected->getId() );
		$this->assertEquals( $expected, $actual );
	}


	public function testSaveUpdateDeleteItem()
	{
		$search = $this->object->createSearch();
		$conditions = array(
			$search->compare( '==', 'order.type', \Aimeos\MShop\Order\Item\Base::TYPE_PHONE ),
			$search->compare( '==', 'order.editor', $this->editor )
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$results = $this->object->searchItems( $search );

		if( ( $item = reset( $results ) ) === false ) {
			throw new \RuntimeException( 'No order item found.' );
		}

		$item->setId( null );
		$itemPrice = clone $item->getPrice();
		$resultSaved = $this->object->saveItem( $item );
		$itemSaved = $this->object->getItem( $item->getId() );
		$itemSavedPrice = clone $itemSaved->getPrice();

		$itemExp = clone $itemSaved;
		$itemExp->setType( \Aimeos\MShop\Order\Item\Base::TYPE_WEB );
		$itemExpPrice = clone $itemExp->getPrice();
		$resultUpd = $this->object->saveItem( $itemExp );
		$itemUpd = $this->object->getItem( $itemExp->getId() );
		$itemUpdPrice = clone $itemUpd->getPrice();

		$this->object->deleteItem( $itemSaved->getId() );


		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getSiteId(), $itemSaved->getSiteId() );
		$this->assertEquals( $item->getType(), $itemSaved->getType() );
		$this->assertEquals( $item->getDatePayment(), $itemSaved->getDatePayment() );
		$this->assertEquals( $item->getDateDelivery(), $itemSaved->getDateDelivery() );
		$this->assertEquals( $item->getPaymentStatus(), $itemSaved->getPaymentStatus() );
		$this->assertEquals( $item->getDeliveryStatus(), $itemSaved->getDeliveryStatus() );
		$this->assertEquals( $item->getRelatedId(), $itemSaved->getRelatedId() );
		$this->assertEquals( $item->getCustomerId(), $itemSaved->getCustomerId() );
		$this->assertEquals( $item->getLocale()->getLanguageId(), $itemSaved->getLocale()->getLanguageId() );
		$this->assertEquals( $item->getCustomerReference(), $itemSaved->getCustomerReference() );
		$this->assertEquals( $item->getComment(), $itemSaved->getComment() );
		$this->assertEquals( $item->getSiteCode(), $itemSaved->getSiteCode() );
		$this->assertEquals( $itemPrice->getValue(), $itemSavedPrice->getValue() );
		$this->assertEquals( $itemPrice->getCosts(), $itemSavedPrice->getCosts() );
		$this->assertEquals( $itemPrice->getRebate(), $itemSavedPrice->getRebate() );
		$this->assertEquals( $itemPrice->getCurrencyId(), $itemSavedPrice->getCurrencyId() );
		$this->assertEquals( $item->getProducts(), $itemSaved->getProducts() );
		$this->assertEquals( $item->getAddresses(), $itemSaved->getAddresses() );
		$this->assertEquals( $item->getCoupons(), $itemSaved->getCoupons() );
		$this->assertEquals( $item->getServices(), $itemSaved->getServices() );

		$this->assertEquals( $this->editor, $itemSaved->getEditor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getSiteId(), $itemUpd->getSiteId() );
		$this->assertEquals( $itemExp->getType(), $itemUpd->getType() );
		$this->assertEquals( $itemExp->getDatePayment(), $itemUpd->getDatePayment() );
		$this->assertEquals( $itemExp->getDateDelivery(), $itemUpd->getDateDelivery() );
		$this->assertEquals( $itemExp->getPaymentStatus(), $itemUpd->getPaymentStatus() );
		$this->assertEquals( $itemExp->getDeliveryStatus(), $itemUpd->getDeliveryStatus() );
		$this->assertEquals( $itemExp->getRelatedId(), $itemUpd->getRelatedId() );
		$this->assertEquals( $itemExp->getCustomerId(), $itemUpd->getCustomerId() );
		$this->assertEquals( $itemExp->getLocale()->getLanguageId(), $itemUpd->getLocale()->getLanguageId() );
		$this->assertEquals( $itemExp->getCustomerReference(), $itemUpd->getCustomerReference() );
		$this->assertEquals( $itemExp->getComment(), $itemUpd->getComment() );
		$this->assertEquals( $itemExp->getSiteCode(), $itemUpd->getSiteCode() );
		$this->assertEquals( $itemExpPrice->getValue(), $itemUpdPrice->getValue() );
		$this->assertEquals( $itemExpPrice->getCosts(), $itemUpdPrice->getCosts() );
		$this->assertEquals( $itemExpPrice->getRebate(), $itemUpdPrice->getRebate() );
		$this->assertEquals( $itemExpPrice->getCurrencyId(), $itemUpdPrice->getCurrencyId() );
		$this->assertEquals( $itemExp->getProducts(), $itemUpd->getProducts() );
		$this->assertEquals( $itemExp->getAddresses(), $itemUpd->getAddresses() );
		$this->assertEquals( $itemExp->getCoupons(), $itemUpd->getCoupons() );
		$this->assertEquals( $itemExp->getServices(), $itemUpd->getServices() );

		$this->assertEquals( $this->editor, $itemUpd->getEditor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultSaved );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultUpd );

		$this->setExpectedException( \Aimeos\MShop\Exception::class );
		$this->object->getItem( $itemSaved->getId() );
	}


	public function testSaveStatusUpdatePayment()
	{
		$statusManager = \Aimeos\MShop::create( $this->context, 'order/status' );

		$search = $this->object->createSearch();
		$conditions = array(
			$search->compare( '==', 'order.type', \Aimeos\MShop\Order\Item\Base::TYPE_PHONE ),
			$search->compare( '==', 'order.editor', $this->editor )
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$results = $this->object->searchItems( $search );

		if( ( $item = reset( $results ) ) === false ) {
			throw new \RuntimeException( 'No order item found.' );
		}

		$item->setId( null );
		$this->object->saveItem( $item );


		$search = $statusManager->createSearch();
		$search->setConditions( $search->compare( '==', 'order.status.parentid', $item->getId() ) );
		$results = $statusManager->searchItems( $search );

		$this->object->deleteItem( $item->getId() );

		$this->assertEquals( 0, count( $results ) );


		$item->setId( null );
		$item->setPaymentStatus( \Aimeos\MShop\Order\Item\Base::PAY_CANCELED );
		$this->object->saveItem( $item );

		$search = $statusManager->createSearch();
		$search->setConditions( $search->compare( '==', 'order.status.parentid', $item->getId() ) );
		$results = $statusManager->searchItems( $search );

		$this->object->deleteItem( $item->getId() );

		if( ( $statusItem = reset( $results ) ) === false ) {
			throw new \RuntimeException( 'No status item found' );
		}

		$this->assertEquals( 1, count( $results ) );
		$this->assertEquals( \Aimeos\MShop\Order\Item\Status\Base::STATUS_PAYMENT, $statusItem->getType() );
		$this->assertEquals( \Aimeos\MShop\Order\Item\Base::PAY_CANCELED, $statusItem->getValue() );
	}


	public function testSaveStatusUpdateDelivery()
	{
		$statusManager = \Aimeos\MShop::create( $this->context, 'order/status' );

		$search = $this->object->createSearch();
		$conditions = array(
			$search->compare( '==', 'order.type', \Aimeos\MShop\Order\Item\Base::TYPE_PHONE ),
			$search->compare( '==', 'order.editor', $this->editor )
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$results = $this->object->searchItems( $search );

		if( ( $item = reset( $results ) ) === false ) {
			throw new \RuntimeException( 'No order item found.' );
		}

		$item->setId( null );
		$this->object->saveItem( $item );


		$search = $statusManager->createSearch();
		$search->setConditions( $search->compare( '==', 'order.status.parentid', $item->getId() ) );
		$results = $statusManager->searchItems( $search );

		$this->object->deleteItem( $item->getId() );

		$this->assertEquals( 0, count( $results ) );


		$item->setId( null );
		$item->setDeliveryStatus( \Aimeos\MShop\Order\Item\Base::STAT_LOST );
		$this->object->saveItem( $item );

		$search = $statusManager->createSearch();
		$search->setConditions( $search->compare( '==', 'order.status.parentid', $item->getId() ) );
		$results = $statusManager->searchItems( $search );

		$this->object->deleteItem( $item->getId() );

		if( ( $statusItem = reset( $results ) ) === false ) {
			throw new \RuntimeException( 'No status item found' );
		}

		$this->assertEquals( 1, count( $results ) );
		$this->assertEquals( \Aimeos\MShop\Order\Item\Status\Base::STATUS_DELIVERY, $statusItem->getType() );
		$this->assertEquals( \Aimeos\MShop\Order\Item\Base::STAT_LOST, $statusItem->getValue() );
	}


	public function testCreateSearch()
	{
		$this->assertInstanceOf( \Aimeos\MW\Criteria\Iface::class, $this->object->createSearch() );
	}


	public function testSearchItems()
	{
		$siteid = $this->context->getLocale()->getSiteId();

		$total = 0;
		$search = $this->object->createSearch();

		$funcStatPayment = $search->createFunction( 'order.containsStatus', ['typestatus', 'shipped'] );
		$funcStatus = $search->createFunction( 'order:status', ['typestatus'] );

		$expr = [];
		$expr[] = $search->compare( '!=', 'order.id', null );
		$expr[] = $search->compare( '==', 'order.siteid', $siteid );
		$expr[] = $search->compare( '==', 'order.type', 'web' );
		$expr[] = $search->compare( '==', 'order.datepayment', '2008-02-15 12:34:56' );
		$expr[] = $search->compare( '==', 'order.datedelivery', null );
		$expr[] = $search->compare( '==', 'order.statuspayment', \Aimeos\MShop\Order\Item\Base::PAY_RECEIVED );
		$expr[] = $search->compare( '==', 'order.statusdelivery', 4 );
		$expr[] = $search->compare( '==', 'order.relatedid', null );
		$expr[] = $search->compare( '==', 'order.sitecode', 'unittest' );
		$expr[] = $search->compare( '>=', 'order.customerid', '' );
		$expr[] = $search->compare( '==', 'order.languageid', 'de' );
		$expr[] = $search->compare( '==', 'order.currencyid', 'EUR' );
		$expr[] = $search->compare( '==', 'order.price', '53.50' );
		$expr[] = $search->compare( '==', 'order.costs', '1.50' );
		$expr[] = $search->compare( '==', 'order.rebate', '14.50' );
		$expr[] = $search->compare( '~=', 'order.comment', 'This is a comment' );
		$expr[] = $search->compare( '>=', 'order.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'order.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'order.editor', $this->editor );
		$expr[] = $search->compare( '==', $funcStatus, 'shipped' );
		$expr[] = $search->compare( '==', $funcStatPayment, 1 );

		$expr[] = $search->compare( '!=', 'order.status.id', null );
		$expr[] = $search->compare( '==', 'order.status.siteid', $siteid );
		$expr[] = $search->compare( '!=', 'order.status.parentid', null );
		$expr[] = $search->compare( '>=', 'order.status.type', 'typestatus' );
		$expr[] = $search->compare( '==', 'order.status.value', 'shipped' );
		$expr[] = $search->compare( '>=', 'order.status.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'order.status.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'order.status.editor', $this->editor );

		$expr[] = $search->compare( '!=', 'order.address.id', null );
		$expr[] = $search->compare( '==', 'order.address.siteid', $siteid );
		$expr[] = $search->compare( '!=', 'order.address.orderid', null );
		$expr[] = $search->compare( '==', 'order.address.type', 'payment' );
		$expr[] = $search->compare( '==', 'order.address.company', '' );
		$expr[] = $search->compare( '==', 'order.address.vatid', '' );
		$expr[] = $search->compare( '==', 'order.address.salutation', 'mr' );
		$expr[] = $search->compare( '==', 'order.address.title', '' );
		$expr[] = $search->compare( '==', 'order.address.firstname', 'Our' );
		$expr[] = $search->compare( '==', 'order.address.lastname', 'Unittest' );
		$expr[] = $search->compare( '==', 'order.address.address1', 'Durchschnitt' );
		$expr[] = $search->compare( '==', 'order.address.address2', '1' );
		$expr[] = $search->compare( '==', 'order.address.address3', '' );
		$expr[] = $search->compare( '==', 'order.address.postal', '20146' );
		$expr[] = $search->compare( '==', 'order.address.city', 'Hamburg' );
		$expr[] = $search->compare( '==', 'order.address.state', 'Hamburg' );
		$expr[] = $search->compare( '==', 'order.address.countryid', 'DE' );
		$expr[] = $search->compare( '==', 'order.address.languageid', 'de' );
		$expr[] = $search->compare( '==', 'order.address.telephone', '055544332211' );
		$expr[] = $search->compare( '==', 'order.address.email', 'test@example.com' );
		$expr[] = $search->compare( '==', 'order.address.telefax', '055544332213' );
		$expr[] = $search->compare( '==', 'order.address.website', 'www.metaways.net' );
		$expr[] = $search->compare( '>=', 'order.address.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'order.address.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'order.address.editor', $this->editor );

		$expr[] = $search->compare( '!=', 'order.coupon.id', null );
		$expr[] = $search->compare( '==', 'order.coupon.siteid', $siteid );
		$expr[] = $search->compare( '!=', 'order.coupon.orderid', null );
		$expr[] = $search->compare( '!=', 'order.coupon.productid', null );
		$expr[] = $search->compare( '==', 'order.coupon.code', 'OPQR' );
		$expr[] = $search->compare( '>=', 'order.coupon.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'order.coupon.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'order.coupon.editor', '' );

		$expr[] = $search->compare( '!=', 'order.product.id', null );
		$expr[] = $search->compare( '==', 'order.product.siteid', $siteid );
		$expr[] = $search->compare( '!=', 'order.product.orderid', null );
		$expr[] = $search->compare( '!=', 'order.product.productid', null );
		$expr[] = $search->compare( '==', 'order.product.prodcode', 'CNE' );
		$expr[] = $search->compare( '==', 'order.product.suppliercode', 'unitsupplier' );
		$expr[] = $search->compare( '==', 'order.product.name', 'Cafe Noire Expresso' );
		$expr[] = $search->compare( '==', 'order.product.mediaurl', 'somewhere/thump1.jpg' );
		$expr[] = $search->compare( '==', 'order.product.quantity', 9 );
		$expr[] = $search->compare( '==', 'order.product.price', '4.50' );
		$expr[] = $search->compare( '==', 'order.product.costs', '0.00' );
		$expr[] = $search->compare( '==', 'order.product.rebate', '0.00' );
		$expr[] = $search->compare( '=~', 'order.product.taxrates', '{' );
		$expr[] = $search->compare( '==', 'order.product.flags', 0 );
		$expr[] = $search->compare( '==', 'order.product.position', 1 );
		$expr[] = $search->compare( '==', 'order.product.status', 1 );
		$expr[] = $search->compare( '>=', 'order.product.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'order.product.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'order.product.editor', $this->editor );

		$expr[] = $search->compare( '!=', 'order.product.attribute.id', null );
		$expr[] = $search->compare( '==', 'order.product.attribute.siteid', $siteid );
		$expr[] = $search->compare( '!=', 'order.product.attribute.parentid', null );
		$expr[] = $search->compare( '==', 'order.product.attribute.code', 'width' );
		$expr[] = $search->compare( '==', 'order.product.attribute.value', '33' );
		$expr[] = $search->compare( '==', 'order.product.attribute.name', '33' );
		$expr[] = $search->compare( '==', 'order.product.attribute.quantity', 1 );
		$expr[] = $search->compare( '>=', 'order.product.attribute.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'order.product.attribute.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'order.product.attribute.editor', $this->editor );

		$expr[] = $search->compare( '!=', 'order.service.id', null );
		$expr[] = $search->compare( '==', 'order.service.siteid', $siteid );
		$expr[] = $search->compare( '!=', 'order.service.orderid', null );
		$expr[] = $search->compare( '==', 'order.service.type', 'payment' );
		$expr[] = $search->compare( '==', 'order.service.code', 'OGONE' );
		$expr[] = $search->compare( '==', 'order.service.name', 'ogone' );
		$expr[] = $search->compare( '==', 'order.service.price', '0.00' );
		$expr[] = $search->compare( '==', 'order.service.costs', '0.00' );
		$expr[] = $search->compare( '==', 'order.service.rebate', '0.00' );
		$expr[] = $search->compare( '=~', 'order.service.taxrates', '{' );
		$expr[] = $search->compare( '>=', 'order.service.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'order.service.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'order.service.editor', $this->editor );

		$expr[] = $search->compare( '!=', 'order.service.attribute.id', null );
		$expr[] = $search->compare( '==', 'order.service.attribute.siteid', $siteid );
		$expr[] = $search->compare( '!=', 'order.service.attribute.parentid', null );
		$expr[] = $search->compare( '==', 'order.service.attribute.code', 'NAME' );
		$expr[] = $search->compare( '==', 'order.service.attribute.value', '"CreditCard"' );
		$expr[] = $search->compare( '==', 'order.service.attribute.quantity', 1 );
		$expr[] = $search->compare( '>=', 'order.service.attribute.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'order.service.attribute.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'order.service.attribute.editor', $this->editor );



		$search->setConditions( $search->combine( '&&', $expr ) );
		$result = $this->object->searchItems( $search, [], $total );

		$this->assertEquals( 1, count( $result ) );
		$this->assertEquals( 1, $total );


		$search = $this->object->createSearch();
		$conditions = array(
			$search->compare( '==', 'order.statuspayment', \Aimeos\MShop\Order\Item\Base::PAY_RECEIVED ),
			$search->compare( '==', 'order.editor', $this->editor )
		);
		$search->setConditions( $search->combine( '&&', $conditions ) );
		$search->setSlice( 0, 1 );
		$total = 0;
		$items = $this->object->searchItems( $search, [], $total );

		$this->assertEquals( 1, count( $items ) );
		$this->assertEquals( 3, $total );

		foreach( $items as $itemId => $item ) {
			$this->assertEquals( $itemId, $item->getId() );
		}
	}


	public function testGetSubManager()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'status' ) );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'status', 'Standard' ) );

		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'address' ) );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'address', 'Standard' ) );

		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'coupon' ) );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'coupon', 'Standard' ) );

		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'product' ) );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'product', 'Standard' ) );

		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'service' ) );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->getSubManager( 'service', 'Standard' ) );

		$this->setExpectedException( \Aimeos\MShop\Exception::class );
		$this->object->getSubManager( 'unknown' );
	}


	public function testGetSubManagerInvalidName()
	{
		$this->setExpectedException( \Aimeos\MShop\Exception::class );
		$this->object->getSubManager( 'address', 'unknown' );
	}


	public function testLoad()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId() );


		foreach( $order->getAddresses() as $addresses )
		{
			foreach( $addresses as $address )
			{
				$this->assertNotEquals( '', $address->getId() );
				$this->assertNotEquals( '', $address->getId() );
				$this->assertNotEquals( '', $address->getOrderId() );
			}
		}

		$this->assertEquals( 2, count( $order->getCoupons() ) );

		foreach( $order->getCoupons() as $code => $products )
		{
			$this->assertNotEquals( '', $code );

			foreach( $products as $product ) {
				$this->assertInstanceOf( \Aimeos\MShop\Order\Item\Product\Iface::class, $product );
			}
		}

		foreach( $order->getProducts() as $product )
		{
			$this->assertNotEquals( '', $product->getId() );
			$this->assertNotEquals( '', $product->getId() );
			$this->assertNotEquals( '', $product->getOrderId() );
			$this->assertGreaterThan( 0, $product->getPosition() );
		}

		foreach( $order->getServices() as $list )
		{
			foreach( $list as $service )
			{
				$this->assertNotEquals( '', $service->getId() );
				$this->assertNotEquals( '', $service->getId() );
				$this->assertNotEquals( '', $service->getOrderId() );
			}
		}
	}


	public function testLoadNone()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_NONE );

		$this->assertEquals( [], $order->getProducts() );
		$this->assertEquals( [], $order->getCoupons() );
		$this->assertEquals( [], $order->getServices() );
		$this->assertEquals( [], $order->getAddresses() );
	}


	public function testLoadAddress()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ADDRESS );

		$this->assertGreaterThan( 0, count( $order->getAddresses() ) );
		$this->assertEquals( [], $order->getCoupons() );
		$this->assertEquals( [], $order->getProducts() );
		$this->assertEquals( [], $order->getServices() );
	}


	public function testLoadProduct()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_PRODUCT );

		$this->assertGreaterThan( 0, count( $order->getProducts() ) );
		$this->assertEquals( [], $order->getCoupons() );
		$this->assertEquals( [], $order->getServices() );
		$this->assertEquals( [], $order->getAddresses() );
	}


	public function testLoadCoupon()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_COUPON );

		$this->assertGreaterThan( 0, count( $order->getProducts() ) );
		$this->assertGreaterThan( 0, count( $order->getCoupons() ) );
		$this->assertEquals( [], $order->getServices() );
		$this->assertEquals( [], $order->getAddresses() );
	}


	public function testLoadService()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_SERVICE );

		$this->assertGreaterThan( 0, count( $order->getServices() ) );
		$this->assertEquals( [], $order->getCoupons() );
		$this->assertEquals( [], $order->getProducts() );
		$this->assertEquals( [], $order->getAddresses() );
	}


	public function testLoadFresh()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ALL, true );


		$this->assertEquals( 2, count( $order->getCoupons() ) );

		foreach( $order->getAddresses() as $list )
		{
			foreach( $list as $address )
			{
				$this->assertEquals( null, $address->getId() );
				$this->assertEquals( null, $address->getOrderId() );
			}
		}

		foreach( $order->getProducts() as $product )
		{
			$this->assertEquals( null, $product->getId() );
			$this->assertEquals( null, $product->getOrderId() );
			$this->assertEquals( null, $product->getPosition() );
		}

		foreach( $order->getServices() as $list )
		{
			foreach( $list as $service )
			{
				$this->assertEquals( null, $service->getId() );
				$this->assertEquals( null, $service->getOrderId() );
			}
		}
	}


	public function testLoadFreshNone()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_NONE, true );

		$this->assertEquals( [], $order->getAddresses() );
		$this->assertEquals( [], $order->getCoupons() );
		$this->assertEquals( [], $order->getProducts() );
		$this->assertEquals( [], $order->getServices() );
	}


	public function testLoadFreshAddress()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ADDRESS, true );

		$this->assertGreaterThan( 0, count( $order->getAddresses() ) );
		$this->assertEquals( [], $order->getCoupons() );
		$this->assertEquals( [], $order->getProducts() );
		$this->assertEquals( [], $order->getServices() );
	}


	public function testLoadFreshProduct()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_PRODUCT, true );

		$this->assertGreaterThan( 0, count( $order->getProducts() ) );
		$this->assertEquals( [], $order->getCoupons() );
		$this->assertEquals( [], $order->getAddresses() );
		$this->assertEquals( [], $order->getServices() );
	}


	public function testLoadFreshCoupon()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_COUPON, true );

		$this->assertEquals( [], $order->getAddresses() );
		$this->assertEquals( 2, count( $order->getCoupons() ) );
		$this->assertEquals( [], $order->getProducts() );
		$this->assertEquals( [], $order->getServices() );
	}


	public function testLoadFreshService()
	{
		$item = $this->getOrderItem();
		$order = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_SERVICE, true );

		$this->assertGreaterThan( 0, count( $order->getServices() ) );
		$this->assertEquals( [], $order->getCoupons() );
		$this->assertEquals( [], $order->getAddresses() );
		$this->assertEquals( [], $order->getProducts() );
	}


	public function testStore()
	{
		$item = $this->getOrderItem();

		$basket = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ALL, true );
		$this->object->store( $basket );

		$newBasketId = $basket->getId();

		$basket = $this->object->load( $newBasketId );
		$this->object->deleteItem( $newBasketId );


		$this->assertEquals( $item->getCustomerId(), $basket->getCustomerId() );
		$this->assertEquals( $basket->getLocale()->getSiteId(), $basket->getSiteId() );

		$this->assertEquals( 6.50, $basket->getPrice()->getCosts() );

		$pos = 0;
		$products = $basket->getProducts();
		$this->assertEquals( 2, count( $products ) );

		foreach( $products as $product )
		{
			$this->assertGreaterThanOrEqual( 2, count( $product->getAttributeItems() ) );
			$this->assertEquals( $pos++, $product->getPosition() );
		}

		$this->assertEquals( 2, count( $basket->getAddresses() ) );

		$services = $basket->getServices();
		$this->assertEquals( 2, count( $services ) );

		$attributes = [];
		foreach( $services as $list )
		{
			foreach( $list as $service ) {
				$attributes[$service->getCode()] = $service->getAttributeItems();
			}
		}

		$this->assertEquals( 9, count( $attributes['OGONE'] ) );
		$this->assertEquals( 0, count( $attributes['73'] ) );

		$this->setExpectedException( \Aimeos\MShop\Exception::class );
		$this->object->getItem( $newBasketId );
	}


	public function testStoreExisting()
	{
		$item = $this->getOrderItem();

		$basket = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ALL, true );
		$this->object->store( $basket );
		$newBasketId = $basket->getId();
		$this->object->store( $basket );
		$newBasket = $this->object->load( $newBasketId );

		$this->object->deleteItem( $newBasketId );


		$newAddresses = $newBasket->getAddresses();

		foreach( $basket->getAddresses() as $key => $list )
		{
			foreach( $list as $pos => $address ) {
				$this->assertEquals( $address->getId(), $newAddresses[$key][$pos]->getId() );
			}
		}

		$newProducts = $newBasket->getProducts();

		foreach( $basket->getProducts() as $key => $product )
		{
			$this->assertEquals( $product->getId(), $newProducts[$key]->getId() );
			$this->assertEquals( $product->getPosition(), $newProducts[$key]->getPosition() );
		}

		$newServices = $newBasket->getServices();

		foreach( $basket->getServices() as $key => $list )
		{
			foreach( $list as $pos => $service ) {
				$this->assertEquals( $service->getId(), $newServices[$key][$pos]->getId() );
			}
		}
	}


	public function testStoreBundles()
	{
		$search = $this->object->createSearch();

		$expr = [];
		$expr[] = $search->compare( '==', 'order.sitecode', 'unittest' );
		$expr[] = $search->compare( '==', 'order.price', 4800.00 );
		$search->setConditions( $search->combine( '&&', $expr ) );
		$results = $this->object->searchItems( $search );

		if( ( $item = reset( $results ) ) == false ) {
			throw new \RuntimeException( 'No order found' );
		}

		$basket = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ALL, true );
		$this->object->store( $basket );

		$newBasketId = $basket->getId();

		$basket = $this->object->load( $newBasketId );
		$this->object->deleteItem( $newBasketId );

		$this->assertEquals( $item->getCustomerId(), $basket->getCustomerId() );
		$this->assertEquals( $basket->getLocale()->getSiteId(), $basket->getSiteId() );

		$pos = 0;
		$products = $basket->getProducts();

		$this->assertEquals( 2, count( $products ) );
		foreach( $products as $product )
		{
			$this->assertEquals( 2, count( $product->getProducts() ) );
			$this->assertEquals( $pos, $product->getPosition() );
			$pos += 3; // two sub-products in between
		}

		$this->setExpectedException( \Aimeos\MShop\Exception::class );
		$this->object->getItem( $newBasketId );
	}


	public function testStoreNone()
	{
		$item = $this->getOrderItem();

		$basket = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ALL, true );
		$this->object->store( $basket, \Aimeos\MShop\Order\Item\Base::PARTS_NONE );

		$newBasketId = $basket->getId();

		$basket = $this->object->load( $newBasketId, \Aimeos\MShop\Order\Item\Base::PARTS_ALL );
		$this->object->deleteItem( $newBasketId );

		$this->assertEquals( [], $basket->getCoupons() );
		$this->assertEquals( [], $basket->getAddresses() );
		$this->assertEquals( [], $basket->getProducts() );
		$this->assertEquals( [], $basket->getServices() );
	}


	public function testStoreAddress()
	{
		$item = $this->getOrderItem();

		$basket = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ALL, true );
		$this->object->store( $basket, \Aimeos\MShop\Order\Item\Base::PARTS_ADDRESS );

		$newBasketId = $basket->getId();

		$basket = $this->object->load( $newBasketId, \Aimeos\MShop\Order\Item\Base::PARTS_ALL );
		$this->object->deleteItem( $newBasketId );

		$this->assertGreaterThan( 0, count( $basket->getAddresses() ) );
		$this->assertEquals( [], $basket->getCoupons() );
		$this->assertEquals( [], $basket->getProducts() );
		$this->assertEquals( [], $basket->getServices() );
	}


	public function testStoreProduct()
	{
		$item = $this->getOrderItem();

		$basket = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ALL, true );
		$this->object->store( $basket, \Aimeos\MShop\Order\Item\Base::PARTS_PRODUCT );

		$newBasketId = $basket->getId();

		$basket = $this->object->load( $newBasketId, \Aimeos\MShop\Order\Item\Base::PARTS_ALL );
		$this->object->deleteItem( $newBasketId );

		$this->assertGreaterThan( 0, count( $basket->getProducts() ) );
		$this->assertEquals( [], $basket->getAddresses() );
		$this->assertEquals( [], $basket->getCoupons() );
		$this->assertEquals( [], $basket->getServices() );
	}


	public function testStoreService()
	{
		$item = $this->getOrderItem();

		$basket = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ALL, true );
		$this->object->store( $basket, \Aimeos\MShop\Order\Item\Base::PARTS_SERVICE );

		$newBasketId = $basket->getId();

		$basket = $this->object->load( $newBasketId, \Aimeos\MShop\Order\Item\Base::PARTS_ALL );
		$this->object->deleteItem( $newBasketId );

		$this->assertGreaterThan( 0, count( $basket->getServices() ) );
		$this->assertEquals( [], $basket->getAddresses() );
		$this->assertEquals( [], $basket->getCoupons() );
		$this->assertEquals( [], $basket->getProducts() );
	}


	public function testLoadStoreCoupons()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'order.price', '53.50' ) );
		$results = $this->object->searchItems( $search );

		if( ( $item = reset( $results ) ) === false ) {
			throw new \RuntimeException( 'No order found' );
		}

		$parts = \Aimeos\MShop\Order\Item\Base::PARTS_ALL ^ \Aimeos\MShop\Order\Item\Base::PARTS_COUPON;
		$basket = $this->object->load( $item->getId(), $parts, true );

		$this->assertEquals( '58.50', $basket->getPrice()->getValue() );
		$this->assertEquals( '6.50', $basket->getPrice()->getCosts() );
		$this->assertEquals( 0, count( $basket->getCoupons() ) );

		$productBasket = $this->object->load( $item->getId(), \Aimeos\MShop\Order\Item\Base::PARTS_ALL, true );

		$basket->addCoupon( 'CDEF' );
		$basket->addCoupon( '90AB' );
		$this->assertEquals( 2, count( $basket->getCoupons() ) );

		$this->object->store( $basket );
		$newBasket = $this->object->load( $basket->getId() );
		$this->object->deleteItem( $newBasket->getId() );

		$this->assertEquals( '52.50', $newBasket->getPrice()->getValue() );
		$this->assertEquals( '1.50', $newBasket->getPrice()->getCosts() );
		$this->assertEquals( '6.00', $newBasket->getPrice()->getRebate() );
		$this->assertEquals( 2, count( $newBasket->getCoupons() ) );
	}


	/**
	 * Returns an order item
	 *
	 * @return \Aimeos\MShop\Order\Item\Iface Order item
	 * @throws \Exception If no found
	 */
	protected function getOrderItem()
	{
		$search = $this->object->createSearch();

		$expr = [];
		$expr[] = $search->compare( '==', 'order.rebate', 14.50 );
		$expr[] = $search->compare( '==', 'order.sitecode', 'unittest' );
		$expr[] = $search->compare( '==', 'order.price', 53.50 );
		$expr[] = $search->compare( '==', 'order.editor', $this->editor );
		$search->setConditions( $search->combine( '&&', $expr ) );
		$results = $this->object->searchItems( $search );

		if( ( $item = reset( $results ) ) === false ) {
			throw new \RuntimeException( 'No order found' );
		}

		return $item;
	}
}
