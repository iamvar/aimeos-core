<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds the coupon test data.
 */
class CouponAddTestData extends \Aimeos\MW\Setup\Task\Base
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies() : array
	{
		return ['OrderAddTestData'];
	}


	/**
	 * Adds coupon test data.
	 */
	public function migrate()
	{
		$this->msg( 'Adding coupon test data', 0 );

		$ds = DIRECTORY_SEPARATOR;
		$path = __DIR__ . $ds . 'data' . $ds . 'coupon.php';

		if( ( $testdata = include( $path ) ) == false ) {
			throw new \Aimeos\MShop\Exception( sprintf( 'No file "%1$s" found for coupon test data', $path ) );
		}

		$this->addCouponData( $testdata );

		$this->status( 'done' );
	}


	/**
	 * Adds the coupon test data.
	 *
	 * @param array $testdata Associative list of key/list pairs
	 * @throws \Aimeos\MW\Setup\Exception If a required ID is not available
	 */
	private function addCouponData( array $testdata )
	{
		$couponManager = \Aimeos\MShop\Coupon\Manager\Factory::create( $this->additional, 'Standard' );
		$couponCodeManager = $couponManager->getSubmanager( 'code' );

		$couponIds = [];
		$coupon = $couponManager->createItem();
		foreach( $testdata['coupon'] as $key => $dataset )
		{
			$coupon->setId( null );
			$coupon->setLabel( $dataset['label'] );
			$coupon->setProvider( $dataset['provider'] );
			$coupon->setDateStart( $dataset['start'] );
			$coupon->setDateEnd( $dataset['end'] );
			$coupon->setConfig( $dataset['config'] );
			$coupon->setStatus( $dataset['status'] );

			$couponManager->saveItem( $coupon );
			$couponIds[$key] = $coupon->getId();
		}


		$ccode = $couponCodeManager->createItem();
		foreach( $testdata['coupon/code'] as $key => $dataset )
		{
			if( !isset( $couponIds[$dataset['parentid']] ) ) {
				throw new \Aimeos\MW\Setup\Exception( sprintf( 'No coupon ID found for "%1$s"', $dataset['parentid'] ) );
			}

			$ccode->setId( null );
			$ccode->setParentId( $couponIds[$dataset['parentid']] );
			$ccode->setCount( $dataset['count'] );
			$ccode->setDateStart( $dataset['start'] );
			$ccode->setDateEnd( $dataset['end'] );
			$ccode->setCode( $dataset['code'] );

			$couponCodeManager->saveItem( $ccode, false );
		}
	}
}
