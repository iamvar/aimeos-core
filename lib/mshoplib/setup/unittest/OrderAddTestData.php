<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds order test data.
 */
class OrderAddTestData extends \Aimeos\MW\Setup\Task\Base
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies() : array
	{
		return ['CustomerAddTestData', 'ProductAddTestData', 'PluginAddTestData', 'ServiceAddTestData'];
	}


	/**
	 * Adds order test data.
	 */
	public function migrate()
	{
		\Aimeos\MW\Common\Base::checkClass( \Aimeos\MShop\Context\Item\Iface::class, $this->additional );

		$this->msg( 'Adding order test data', 0 );
		$this->additional->setEditor( 'core:lib/mshoplib' );

		$orderManager = \Aimeos\MShop\Order\Manager\Factory::create( $this->additional, 'Standard' );

		$search = $orderManager->createSearch();
		$search->setConditions( $search->compare( '=~', 'order.sitecode', 'unit' ) );

		$orderManager->deleteItems( array_keys( $orderManager->searchItems( $search ) ) );


		$ds = DIRECTORY_SEPARATOR;
		$path = __DIR__ . $ds . 'data' . $ds . 'order.php';

		if( ( $testdata = include( $path ) ) == false ) {
			throw new \Aimeos\MShop\Exception( sprintf( 'No file "%1$s" found for order domain', $path ) );
		}

		$this->additional->setLocale( $this->additional->getLocale()->setCurrencyId( 'EUR' ) );
		$this->addOrders( $orderManager, $testdata );
		$this->additional->setLocale( $this->additional->getLocale()->setCurrencyId( null ) );

		$this->status( 'done' );
	}


	protected function addOrders( \Aimeos\MShop\Common\Manager\Iface $orderManager, array $testdata )
	{
		$subManager = \Aimeos\MShop::create( $this->additional, 'subscription' );
		$custManager = \Aimeos\MShop::create( $this->additional, 'customer' );
		$addrManager = $orderManager->getSubManager( 'address' );
		$coupManager = $orderManager->getSubManager( 'coupon' );
		$prodManager = $orderManager->getSubManager( 'product' );
		$servManager = $orderManager->getSubManager( 'service' );
		$statManager = $orderManager->getSubManager( 'status' );

		$custId = $custManager->findItem( 'UTC001' )->getId();

		foreach( $testdata['order'] ?? [] as $entry )
		{
			$oid = $orderManager->saveItem( $orderManager->createItem( $entry )->setCustomerId( $custId )->setId( null ) )->getId();

			foreach( $entry['address'] ?? [] as $addr ) {
				$addrManager->saveItem( $addrManager->createItem( $addr )->setOrderId( $oid )->setId( null ) );
			}

			foreach( $entry['coupon'] ?? [] as $coupon ) {
				$coupManager->saveItem( $coupManager->createItem( $coupon)->setOrderId( $oid )->setId( null ) );
			}

			foreach( $entry['product'] ?? [] as $idx => $product )
			{
				$subProducts = $attrItems = $couponItems = [];

				foreach( $product['attribute'] ?? [] as $attr ) {
					$attrItems[] = $prodManager->createAttributeItem( $attr )->setId( null );
				}

				foreach( $product['product'] ?? [] as $sub ) {
					$subProducts[] = $prodManager->createItem( $sub )->setId( null );
				}

				$prodItem = $prodManager->createItem( $product )->setId( null );
				$prodItem = $prodItem->setOrderId( $oid )->setAttributeItems( $attrItems )->setProducts( $subProducts );
				$prodId = $prodManager->saveItem( $prodItem )->getId();

				if( isset( $product['subscription'] ) )
				{
					$subscription = $subManager->createItem( $product['subscription'] );
					$subManager->saveItem( $subscription->setOrderId( $oid )->setProductId( $prodId ) );
				}

				foreach( $product['coupon'] ?? [] as $coupon ) {
					$couponItems[] = $coupManager->createItem( $coupon )->setOrderId( $oid )->setProductId( $prodId )->setId( null );
				}

				$coupManager->saveItems( $couponItems, false );
			}

			foreach( $entry['service'] ?? [] as $service )
			{
				$attrItems = [];

				foreach( $service['attribute'] ?? [] as $attr ) {
					$attrItems[] = $servManager->createAttributeItem( $attr )->setId( null );
				}

				$servItem = $servManager->createItem( $service );
				$servManager->saveItem( $servItem->setOrderId( $oid )->setAttributeItems( $attrItems )->setId( null ) );
			}

			foreach( $entry['status'] ?? [] as $status )
			{
				$statItem = $statManager->createItem( $status );
				$statManager->saveItem( $statItem->setParentId( $oid )->setId( null ) );
			}
		}
	}
}
