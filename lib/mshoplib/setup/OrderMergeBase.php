<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Merges the order and order base table
 */
class OrderMergeBase extends \Aimeos\MW\Setup\Task\Base
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies() : array
	{
		return ['TablesCreateMShop'];
	}


	/**
	 * Executes the table cleanup
	 */
	public function clean()
	{
		$sm = $this->getSchemaManager( 'db-order' );
		$src = $sm->createSchema();
		$dest = clone $src;

		$tables = [
			'mshop_order_base', 'mshop_order_base_address', 'mshop_order_base_coupon',
			'mshop_order_base_product', 'mshop_order_base_product_attr',
			'mshop_order_base_service', 'mshop_order_base_service_attr'
		];

		foreach( $tables as $table )
		{
			if( $src->hasTable( $table ) ) {
				$dest->dropTable( $table->getName() );
			}
		}

		$this->update( $src, $dest, 'db-order' );
	}


	/**
	 * Executes the migration
	 */
	public function migrate()
	{
		$this->msg( 'Migrate order domain', 0, '' );

		$sm = $this->getSchemaManager( 'db-order' );
		$src = $sm->createSchema();

		if( !$src->hasTable( 'mshop_order' ) || !$src->getTable( 'mshop_order' )->hasColumn( 'baseid' ) ) {
			return $this->status( 'OK' );
		}

		if( $src->hasTable( 'mshop_order_base' ) ) {
			$this->updateBase();
		}

		if( $src->hasTable( 'mshop_order_base_address' ) ) {
			$this->updateAddresses();
		}

		if( $src->hasTable( 'mshop_order_base_product' ) ) {
			$this->updateProducts();
		}

		if( $src->hasTable( 'mshop_order_base_product_attr' ) ) {
			$this->updateProductAttributes();
		}

		if( $src->hasTable( 'mshop_order_base_service' ) ) {
			$this->updateServices();
		}

		if( $src->hasTable( 'mshop_order_base_service_attr' ) ) {
			$this->updateServiceAttributes();
		}

		if( $src->hasTable( 'mshop_order_base_coupon' ) ) {
			$this->updateCoupons();
		}
	}


	protected function updateBase()
	{
		$this->msg( 'Merge mshop_order and mshop_order_base tables', 1 );

		$conn = $this->acquire( 'db-order' );
		$conn2 = $this->acquire( 'db-order' );

		$select = 'SELECT * FROM "mshop_order_base" LIMIT 1000 OFFSET :offset';
		$update = '
			UPDATE "mshop_order"
			SET "sitecode" = ?, "customerid" = ?, "langid" = ?, "currencyid" = ?, "price" = ?, "costs" = ?,
				"rebate" = ?, "tax" = ?, "taxflag" = ?, "customerref" = ?, "comment" = ?
			WHERE "baseid" = ?
		';

		$stmt = $conn2->create( $update, \Aimeos\MW\DB\Connection\Base::TYPE_PREP );
		$start = 0;

		$conn2->begin();

		do
		{
			$count = 0;
			$result = $conn->create( str_replace( ':offset', $start, $select ) )->execute();

			while( ( $row = $result->fetch() ) !== false )
			{
				$stmt->bind( 1, (string) $row['sitecode'] );
				$stmt->bind( 2, (string) $row['customerid'] );
				$stmt->bind( 3, (string) $row['langid'] );
				$stmt->bind( 4, (string) $row['currencyid'] );
				$stmt->bind( 5, (string) $row['price'] );
				$stmt->bind( 6, (string) $row['costs'] );
				$stmt->bind( 7, (string) $row['rebate'] );
				$stmt->bind( 8, (string) $row['tax'] );
				$stmt->bind( 9, $row['taxflag'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
				$stmt->bind( 10, (string) $row['customerref'] );
				$stmt->bind( 11, (string) $row['comment'] );
				$stmt->bind( 12, $row['id'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );

				$stmt->execute()->finish();
				$count++;
			}

			$start += $count;
		}
		while( $count === 1000 );

		$conn2->commit();

		$this->release( $conn2, 'db-order' );
		$this->release( $conn, 'db-order' );

		$this->status( 'done' );
	}


	protected function updateAddresses()
	{
		$this->msg( 'Copy mshop_order_base_address to mshop_order_address', 1 );

		$conn = $this->acquire( 'db-order' );
		$conn2 = $this->acquire( 'db-order' );

		$select = '
			SELECT o."id" AS "ordid", oba.* FROM "mshop_order" AS o
			JOIN "mshop_order_base_address" AS oba ON oba."baseid" = o."baseid"
			LIMIT 1000 OFFSET :offset
		';
		$update = '
			INSERT "mshop_order_address"
			SET "orderid" = ?, "siteid" = ?, "addrid" = ?, "type" = ?, "salutation" = ?,
				"company" = ?, "vatid" = ?, "title" = ?, "firstname" = ?, "lastname" = ?,
				"address1" = ?, "address2" = ?, "address3" = ?, "postal" = ?, "city" = ?,
				"state" = ?, "langid" = ?, "countryid" = ?, "telephone" = ?, "telefax" = ?,
				"email" = ?, "website" = ?, "longitude" = ?, "latitude" = ?, "pos" = ?,
				"mtime" = ?, "ctime" = ?, "editor" = ?, "id" = ?
		';

		if( $conn->create( 'SELECT "id" FROM "mshop_order_address" LIMIT 1' )->execute()->fetch() === false )
		{
			$stmt = $conn2->create( $update, \Aimeos\MW\DB\Connection\Base::TYPE_PREP );
			$start = 0;

			$conn2->begin();

			do
			{
				$count = 0;
				$result = $conn->create( str_replace( ':offset', $start, $select ) )->execute();

				while( ( $row = $result->fetch() ) !== false )
				{
					$stmt->bind( 1, $row['ordid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 2, $row['siteid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 3, (string) $row['addrid'] );
					$stmt->bind( 4, (string) $row['type'] );
					$stmt->bind( 5, (string) $row['salutation'] );
					$stmt->bind( 6, (string) $row['company'] );
					$stmt->bind( 7, (string) $row['vatid'] );
					$stmt->bind( 8, (string) $row['title'] );
					$stmt->bind( 9, (string) $row['firstname'] );
					$stmt->bind( 10, (string) $row['lastname'] );
					$stmt->bind( 11, (string) $row['address1'] );
					$stmt->bind( 12, (string) $row['address2'] );
					$stmt->bind( 13, (string) $row['address3'] );
					$stmt->bind( 14, (string) $row['postal'] );
					$stmt->bind( 15, (string) $row['city'] );
					$stmt->bind( 16, (string) $row['state'] );
					$stmt->bind( 17, (string) $row['langid'] );
					$stmt->bind( 18, (string) $row['countryid'] );
					$stmt->bind( 19, (string) $row['telephone'] );
					$stmt->bind( 20, (string) $row['telefax'] );
					$stmt->bind( 21, (string) $row['email'] );
					$stmt->bind( 22, (string) $row['website'] );
					$stmt->bind( 23, (string) $row['longitude'] );
					$stmt->bind( 24, (string) $row['latitude'] );
					$stmt->bind( 25, $row['pos'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 26, (string) $row['mtime'] );
					$stmt->bind( 27, (string) $row['ctime'] );
					$stmt->bind( 28, (string) $row['editor'] );
					$stmt->bind( 29, $row['id'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );

					$stmt->execute()->finish();
					$count++;
				}

				$start += $count;
			}
			while( $count === 1000 );

			$conn2->commit();

			$this->status( 'done' );
		}
		else
		{
			$this->status( 'skip' );
		}

		$this->release( $conn2, 'db-order' );
		$this->release( $conn, 'db-order' );
	}


	protected function updateCoupons()
	{
		$this->msg( 'Copy mshop_order_base_coupon to mshop_order_coupon', 1 );

		$conn = $this->acquire( 'db-order' );
		$conn2 = $this->acquire( 'db-order' );

		$select = '
			SELECT o."id" AS "ordid", obc.* FROM "mshop_order" AS o
			JOIN "mshop_order_base_coupon" AS obc ON obc."baseid" = o."baseid"
			LIMIT 1000 OFFSET :offset
		';
		$update = '
			INSERT "mshop_order_coupon"
			SET "orderid" = ?, "siteid" = ?, "ordprodid" = ?, "code" = ?,
				"mtime" = ?, "ctime" = ?, "editor" = ?, "id" = ?
		';

		if( $conn->create( 'SELECT "id" FROM "mshop_order_coupon" LIMIT 1' )->execute()->fetch() === false )
		{
			$stmt = $conn2->create( $update, \Aimeos\MW\DB\Connection\Base::TYPE_PREP );
			$start = 0;

			$conn2->begin();

			do
			{
				$count = 0;
				$result = $conn->create( str_replace( ':offset', $start, $select ) )->execute();

				while( ( $row = $result->fetch() ) !== false )
				{
					$stmt->bind( 1, $row['ordid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 2, $row['siteid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 3, $row['ordprodid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 4, (string) $row['code'] );
					$stmt->bind( 5, (string) $row['mtime'] );
					$stmt->bind( 6, (string) $row['ctime'] );
					$stmt->bind( 7, (string) $row['editor'] );
					$stmt->bind( 8, $row['id'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );

					$stmt->execute()->finish();
					$count++;
				}

				$start += $count;
			}
			while( $count === 1000 );

			$conn2->commit();

			$this->status( 'done' );
		}
		else
		{
			$this->status( 'skip' );
		}

		$this->release( $conn2, 'db-order' );
		$this->release( $conn, 'db-order' );
	}


	protected function updateProducts()
	{
		$this->msg( 'Copy mshop_order_base_product to mshop_order_product', 1 );

		$conn = $this->acquire( 'db-order' );
		$conn2 = $this->acquire( 'db-order' );

		$select = '
			SELECT o."id" AS "ordid", obp.* FROM "mshop_order" AS o
			JOIN "mshop_order_base_product" AS obp ON obp."baseid" = o."baseid"
			LIMIT 1000 OFFSET :offset
		';
		$update = '
			INSERT "mshop_order_product"
			SET "orderid" = ?, "siteid" = ?, "ordprodid" = ?, "ordaddrid" = ?, "type" = ?, "prodid" = ?,
				"prodcode" = ?, "suppliercode" = ?, "stocktype" = ?, "name" = ?, "description" = ?,
				"mediaurl" = ?, "target" = ?, "timeframe" = ?, "quantity" = ?, "currencyid" = ?,
				"price" = ?, "costs" = ?, "rebate" = ?, "tax" = ?, "taxrate" = ?, "taxflag" = ?,
				"flags" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "ctime" = ?, "editor" = ?, "id" = ?
		';

		if( $conn->create( 'SELECT "id" FROM "mshop_order_product" LIMIT 1' )->execute()->fetch() === false )
		{
			$stmt = $conn2->create( $update, \Aimeos\MW\DB\Connection\Base::TYPE_PREP );
			$start = 0;

			$conn2->begin();

			do
			{
				$count = 0;
				$result = $conn->create( str_replace( ':offset', $start, $select ) )->execute();

				while( ( $row = $result->fetch() ) !== false )
				{
					$stmt->bind( 1, $row['ordid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 2, $row['siteid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 3, $row['ordprodid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 4, $row['ordaddrid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 5, (string) $row['type'] );
					$stmt->bind( 6, (string) $row['prodid'] );
					$stmt->bind( 7, (string) $row['prodcode'] );
					$stmt->bind( 8, (string) $row['suppliercode'] );
					$stmt->bind( 9, (string) $row['stocktype'] );
					$stmt->bind( 10, (string) $row['name'] );
					$stmt->bind( 11, (string) $row['description'] );
					$stmt->bind( 12, (string) $row['mediaurl'] );
					$stmt->bind( 13, (string) $row['target'] );
					$stmt->bind( 14, (string) $row['timeframe'] );
					$stmt->bind( 15, $row['quantity'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 16, (string) $row['currencyid'] );
					$stmt->bind( 17, (string) $row['price'] );
					$stmt->bind( 18, (string) $row['costs'] );
					$stmt->bind( 19, (string) $row['rebate'] );
					$stmt->bind( 20, (string) $row['tax'] );
					$stmt->bind( 21, (string) $row['taxrate'] );
					$stmt->bind( 22, $row['taxflag'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 23, $row['flags'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 24, $row['pos'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 25, $row['status'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 26, (string) $row['mtime'] );
					$stmt->bind( 27, (string) $row['ctime'] );
					$stmt->bind( 28, (string) $row['editor'] );
					$stmt->bind( 29, $row['id'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );

					$stmt->execute()->finish();
					$count++;
				}

				$start += $count;
			}
			while( $count === 1000 );

			$conn2->commit();

			$this->status( 'done' );
		}
		else
		{
			$this->status( 'skip' );
		}

		$this->release( $conn2, 'db-order' );
		$this->release( $conn, 'db-order' );
	}


	protected function updateProductAttributes()
	{
		$this->msg( 'Copy mshop_order_base_product_attr to mshop_order_product_attr', 1 );

		$conn = $this->acquire( 'db-order' );
		$conn2 = $this->acquire( 'db-order' );

		$select = '
			SELECT obpa.* FROM "mshop_order" AS o
			JOIN "mshop_order_base_product" AS obp ON obp."baseid" = o."baseid"
			JOIN "mshop_order_base_product_attr" AS obpa ON obpa."ordprodid" = obp."id"
			LIMIT 1000 OFFSET :offset
		';
		$update = '
			INSERT "mshop_order_product_attr"
			SET "parentid" = ?, "siteid" = ?, "attrid" = ?, "type" = ?, "code" = ?, "name" = ?,
				"value" = ?, "mtime" = ?, "ctime" = ?, "editor" = ?, "id" = ?
		';

		if( $conn->create( 'SELECT "id" FROM "mshop_order_product_attr" LIMIT 1' )->execute()->fetch() === false )
		{
			$stmt = $conn2->create( $update, \Aimeos\MW\DB\Connection\Base::TYPE_PREP );
			$start = 0;

			$conn2->begin();

			do
			{
				$count = 0;
				$result = $conn->create( str_replace( ':offset', $start, $select ) )->execute();

				while( ( $row = $result->fetch() ) !== false )
				{
					$stmt->bind( 1, $row['ordprodid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 2, $row['siteid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 3, (string) $row['attrid'] );
					$stmt->bind( 4, (string) $row['type'] );
					$stmt->bind( 5, (string) $row['code'] );
					$stmt->bind( 6, (string) $row['name'] );
					$stmt->bind( 7, (string) $row['value'] );
					$stmt->bind( 8, (string) $row['mtime'] );
					$stmt->bind( 9, (string) $row['ctime'] );
					$stmt->bind( 10, (string) $row['editor'] );
					$stmt->bind( 11, $row['id'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );

					$stmt->execute()->finish();
					$count++;
				}

				$start += $count;
			}
			while( $count === 1000 );

			$conn2->commit();

			$this->status( 'done' );
		}
		else
		{
			$this->status( 'skip' );
		}

		$this->release( $conn2, 'db-order' );
		$this->release( $conn, 'db-order' );
	}


	protected function updateServices()
	{
		$this->msg( 'Copy mshop_order_base_service to mshop_order_service', 1 );

		$conn = $this->acquire( 'db-order' );
		$conn2 = $this->acquire( 'db-order' );

		$select = '
			SELECT o."id" AS "ordid", obs.* FROM "mshop_order" AS o
			JOIN "mshop_order_base_service" AS obs ON obs."baseid" = o."baseid"
			LIMIT 1000 OFFSET :offset
		';
		$update = '
			INSERT "mshop_order_service"
			SET "orderid" = ?, "siteid" = ?, "servid" = ?, "type" = ?, "code" = ?, "name" = ?,
				"mediaurl" = ?, "currencyid" = ?, "price" = ?, "costs" = ?, "rebate" = ?, "tax" = ?,
				"taxrate" = ?, "taxflag" = ?, "pos" = ?, "mtime" = ?, "ctime" = ?, "editor" = ?, "id" = ?
		';

		if( $conn->create( 'SELECT "id" FROM "mshop_order_service" LIMIT 1' )->execute()->fetch() === false )
		{
			$stmt = $conn2->create( $update, \Aimeos\MW\DB\Connection\Base::TYPE_PREP );
			$start = 0;

			$conn2->begin();

			do
			{
				$count = 0;
				$result = $conn->create( str_replace( ':offset', $start, $select ) )->execute();

				while( ( $row = $result->fetch() ) !== false )
				{
					$stmt->bind( 1, $row['ordid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 2, $row['siteid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 3, (string) $row['servid'] );
					$stmt->bind( 4, (string) $row['type'] );
					$stmt->bind( 5, (string) $row['code'] );
					$stmt->bind( 6, (string) $row['name'] );
					$stmt->bind( 7, (string) $row['mediaurl'] );
					$stmt->bind( 8, (string) $row['currencyid'] );
					$stmt->bind( 9, (string) $row['price'] );
					$stmt->bind( 10, (string) $row['costs'] );
					$stmt->bind( 11, (string) $row['rebate'] );
					$stmt->bind( 12, (string) $row['tax'] );
					$stmt->bind( 13, (string) $row['taxrate'] );
					$stmt->bind( 14, $row['taxflag'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 15, $row['pos'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 16, (string) $row['mtime'] );
					$stmt->bind( 17, (string) $row['ctime'] );
					$stmt->bind( 18, (string) $row['editor'] );
					$stmt->bind( 19, $row['id'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );

					$stmt->execute()->finish();
					$count++;
				}

				$start += $count;
			}
			while( $count === 1000 );

			$conn2->commit();

			$this->status( 'done' );
		}
		else
		{
			$this->status( 'skip' );
		}

		$this->release( $conn2, 'db-order' );
		$this->release( $conn, 'db-order' );
	}


	protected function updateServiceAttributes()
	{
		$this->msg( 'Copy mshop_order_base_service_attr to mshop_order_service_attr', 1 );

		$conn = $this->acquire( 'db-order' );
		$conn2 = $this->acquire( 'db-order' );

		$select = '
			SELECT obsa.* FROM "mshop_order" AS o
			JOIN "mshop_order_base_service" AS obs ON obs."baseid" = o."baseid"
			JOIN "mshop_order_base_service_attr" AS obsa ON obsa."ordservid" = obs."id"
			LIMIT 1000 OFFSET :offset
		';
		$update = '
			INSERT "mshop_order_service_attr"
			SET "parentid" = ?, "siteid" = ?, "attrid" = ?, "type" = ?, "code" = ?, "name" = ?,
				"value" = ?, "mtime" = ?, "ctime" = ?, "editor" = ?, "id" = ?
		';

		if( $conn->create( 'SELECT "id" FROM "mshop_order_service_attr" LIMIT 1' )->execute()->fetch() === false )
		{
			$stmt = $conn2->create( $update, \Aimeos\MW\DB\Connection\Base::TYPE_PREP );
			$start = 0;

			$conn2->begin();

			do
			{
				$count = 0;
				$result = $conn->create( str_replace( ':offset', $start, $select ) )->execute();

				while( ( $row = $result->fetch() ) !== false )
				{
					$stmt->bind( 1, $row['ordservid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 2, $row['siteid'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );
					$stmt->bind( 3, (string) $row['attrid'] );
					$stmt->bind( 4, (string) $row['type'] );
					$stmt->bind( 5, (string) $row['code'] );
					$stmt->bind( 6, (string) $row['name'] );
					$stmt->bind( 7, (string) $row['value'] );
					$stmt->bind( 8, (string) $row['mtime'] );
					$stmt->bind( 9, (string) $row['ctime'] );
					$stmt->bind( 10, (string) $row['editor'] );
					$stmt->bind( 11, $row['id'], \Aimeos\MW\DB\Statement\Base::PARAM_INT );

					$stmt->execute()->finish();
					$count++;
				}

				$start += $count;
			}
			while( $count === 1000 );

			$conn2->commit();

			$this->status( 'done' );
		}
		else
		{
			$this->status( 'skip' );
		}

		$this->release( $conn2, 'db-order' );
		$this->release( $conn, 'db-order' );
	}
}
