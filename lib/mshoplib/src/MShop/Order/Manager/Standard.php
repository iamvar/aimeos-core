<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Order
 */


namespace Aimeos\MShop\Order\Manager;


/**
 * Default order manager implementation.
 *
 * @package MShop
 * @subpackage Order
 */
class Standard
	extends \Aimeos\MShop\Order\Manager\Base
	implements \Aimeos\MShop\Order\Manager\Iface, \Aimeos\MShop\Common\Manager\Factory\Iface
{
	private $searchConfig = array(
		'order.id' => array(
			'code' => 'order.id',
			'internalcode' => 'mord."id"',
			'label' => 'Invoice ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'order.siteid' => array(
			'code' => 'order.siteid',
			'internalcode' => 'mord."siteid"',
			'label' => 'Invoice site ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'order.datepayment' => array(
			'code' => 'order.datepayment',
			'internalcode' => 'mord."datepayment"',
			'label' => 'Purchase date',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.datedelivery' => array(
			'code' => 'order.datedelivery',
			'internalcode' => 'mord."datedelivery"',
			'label' => 'Delivery date',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.statusdelivery' => array(
			'code' => 'order.statusdelivery',
			'internalcode' => 'mord."statusdelivery"',
			'label' => 'Delivery status',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'order.statuspayment' => array(
			'code' => 'order.statuspayment',
			'internalcode' => 'mord."statuspayment"',
			'label' => 'Payment status',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'order.type' => array(
			'code' => 'order.type',
			'internalcode' => 'mord."type"',
			'label' => 'Invoice type',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.relatedid' => array(
			'code' => 'order.relatedid',
			'internalcode' => 'mord."relatedid"',
			'label' => 'Related invoice ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'order.sitecode' => array(
			'code' => 'order.sitecode',
			'internalcode' => ' mord."sitecode"',
			'label' => 'Order site code',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.customerid' => array(
			'code' => 'order.customerid',
			'internalcode' => ' mord."customerid"',
			'label' => 'Order customer ID',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.customerref' => array(
			'code' => 'order.customerref',
			'internalcode' => ' mord."customerref"',
			'label' => 'Order customer reference',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.languageid' => array(
			'code' => 'order.languageid',
			'internalcode' => ' mord."langid"',
			'label' => 'Order language code',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.currencyid' => array(
			'code' => 'order.currencyid',
			'internalcode' => ' mord."currencyid"',
			'label' => 'Order currencyid code',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.price' => array(
			'code' => 'order.price',
			'internalcode' => ' mord."price"',
			'label' => 'Order price amount',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.costs' => array(
			'code' => 'order.costs',
			'internalcode' => ' mord."costs"',
			'label' => 'Order shipping amount',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.rebate' => array(
			'code' => 'order.rebate',
			'internalcode' => ' mord."rebate"',
			'label' => 'Order rebate amount',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.tax' => array(
			'code' => 'order.tax',
			'internalcode' => ' mord."tax"',
			'label' => 'Order tax amount',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.taxflag' => array(
			'code' => 'order.taxflag',
			'internalcode' => ' mord."taxflag"',
			'label' => 'Order tax flag (0=net, 1=gross)',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'order.comment' => array(
			'code' => 'order.comment',
			'internalcode' => ' mord."comment"',
			'label' => 'Order comment',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.cdate' => array(
			'code' => 'order.cdate',
			'internalcode' => 'mord."cdate"',
			'label' => 'Create date',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.cmonth' => array(
			'code' => 'order.cmonth',
			'internalcode' => 'mord."cmonth"',
			'label' => 'Create month',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.cweek' => array(
			'code' => 'order.cweek',
			'internalcode' => 'mord."cweek"',
			'label' => 'Create week',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.cwday' => array(
			'code' => 'order.cwday',
			'internalcode' => 'mord."cwday"',
			'label' => 'Create weekday',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.chour' => array(
			'code' => 'order.chour',
			'internalcode' => 'mord."chour"',
			'label' => 'Create hour',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.ctime' => array(
			'code' => 'order.ctime',
			'internalcode' => 'mord."ctime"',
			'label' => 'Create date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.mtime' => array(
			'code' => 'order.mtime',
			'internalcode' => 'mord."mtime"',
			'label' => 'Modify date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.editor' => array(
			'code' => 'order.editor',
			'internalcode' => 'mord."editor"',
			'label' => 'Editor',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order:status' => array(
			'code' => 'order:status()',
			'internalcode' => ':site AND mordst."type" = $1 AND mordst."value"',
			'label' => 'Order has status item, parameter(<type>)',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.containsStatus' => array(
			'code' => 'order.containsStatus()',
			'internalcode' => '( SELECT COUNT(mordst_cs."parentid")
				FROM "mshop_order_status" AS mordst_cs
				WHERE mord."id" = mordst_cs."parentid" AND :site
				AND mordst_cs."type" = $1 AND mordst_cs."value" IN ( $2 ) )',
			'label' => 'Number of order status items, parameter(<type>,<value>)',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
	);


	/**
	 * Creates the manager that will use the given context object.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object with required objects
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );
		$this->setResourceName( 'db-order' );


		$siteIds = $context->getLocale()->getSiteSubTree();

		$name = 'order:status';
		$expr = $this->toExpression( 'mordst."siteid"', $siteIds );
		$this->searchConfig[$name] = str_replace( ':site', $expr, $this->searchConfig[$name] );

		$name = 'order.containsStatus';
		$expr = $this->toExpression( 'mordst_cs."siteid"', $siteIds );
		$this->searchConfig[$name] = str_replace( ':site', $expr, $this->searchConfig[$name] );
	}


	/**
	 * Counts the number items that are available for the values of the given key.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Search criteria
	 * @param string $key Search key to aggregate items for
	 * @return integer[] List of the search keys as key and the number of counted items as value
	 * @todo 2018.01 Add optional parameters to interface
	 */
	public function aggregate( \Aimeos\MW\Criteria\Iface $search, $key, $value = null, $type = null )
	{
		/** mshop/order/manager/standard/aggregate/mysql
		 * Counts the number of records grouped by the values in the key column and matched by the given criteria
		 *
		 * @see mshop/order/manager/standard/aggregate/ansi
		 */

		/** mshop/order/manager/standard/aggregate/ansi
		 * Counts the number of records grouped by the values in the key column and matched by the given criteria
		 *
		 * Groups all records by the values in the key column and counts their
		 * occurence. The matched records can be limited by the given criteria
		 * from the order database. The records must be from one of the sites
		 * that are configured via the context item. If the current site is part
		 * of a tree of sites, the statement can count all records from the
		 * current site and the complete sub-tree of sites.
		 *
		 * As the records can normally be limited by criteria from sub-managers,
		 * their tables must be joined in the SQL context. This is done by
		 * using the "internaldeps" property from the definition of the ID
		 * column of the sub-managers. These internal dependencies specify
		 * the JOIN between the tables and the used columns for joining. The
		 * ":joins" placeholder is then replaced by the JOIN strings from
		 * the sub-managers.
		 *
		 * To limit the records matched, conditions can be added to the given
		 * criteria object. It can contain comparisons like column names that
		 * must match specific values which can be combined by AND, OR or NOT
		 * operators. The resulting string of SQL conditions replaces the
		 * ":cond" placeholder before the statement is sent to the database
		 * server.
		 *
		 * This statement doesn't return any records. Instead, it returns pairs
		 * of the different values found in the key column together with the
		 * number of records that have been found for that key values.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for aggregating order items
		 * @since 2014.09
		 * @category Developer
		 * @see mshop/order/manager/standard/insert/ansi
		 * @see mshop/order/manager/standard/update/ansi
		 * @see mshop/order/manager/standard/newid/ansi
		 * @see mshop/order/manager/standard/delete/ansi
		 * @see mshop/order/manager/standard/search/ansi
		 * @see mshop/order/manager/standard/count/ansi
		 */

		/** mshop/order/manager/standard/aggregateavg/mysql
		 * Computes the average of all values grouped by the key column and matched by the given criteria
		 *
		 * @param string SQL statement for aggregating the order items and computing the average value
		 * @since 2017.10
		 * @category Developer
		 * @see mshop/order/manager/standard/aggregateavg/ansi
		 * @see mshop/order/manager/standard/aggregate/mysql
		 */

		/** mshop/order/manager/standard/aggregateavg/ansi
		 * Computes the average of all values grouped by the key column and matched by the given criteria
		 *
		 * @param string SQL statement for aggregating the order items and computing the average value
		 * @since 2017.10
		 * @category Developer
		 * @see mshop/order/manager/standard/aggregate/ansi
		 */

		/** mshop/order/manager/standard/aggregatesum/mysql
		 * Computes the sum of all values grouped by the key column and matched by the given criteria
		 *
		 * @param string SQL statement for aggregating the order items and computing the sum
		 * @since 2017.10
		 * @category Developer
		 * @see mshop/order/manager/standard/aggregatesum/ansi
		 * @see mshop/order/manager/standard/aggregate/mysql
		 */

		/** mshop/order/manager/standard/aggregatesum/ansi
		 * Computes the sum of all values grouped by the key column and matched by the given criteria
		 *
		 * @param string SQL statement for aggregating the order items and computing the sum
		 * @since 2017.10
		 * @category Developer
		 * @see mshop/order/manager/standard/aggregate/ansi
		 */

		$cfgkey = 'mshop/order/manager/standard/aggregate' . $type;
		return $this->aggregateBase( $search, $key, $cfgkey, array( 'order' ), $value );
	}


	/**
	 * Removes old entries from the storage.
	 *
	 * @param string[] $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Order\Manager\Iface Manager object for chaining method calls
	 */
	public function clear( array $siteids )
	{
		$path = 'mshop/order/manager/submanagers';
		$ref = ['status', 'address', 'coupon', 'product', 'service'];

		foreach( $this->getContext()->getConfig()->get( $path, $ref ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/order/manager/standard/delete' );
	}


	/**
	 * Creates a new empty item instance
	 *
	 * @param array $values Values the item should be initialized with
	 * @return \Aimeos\MShop\Order\Item\Iface New order item object
	 */
	public function createItem( array $values = [] )
	{
		$context = $this->getContext();
		$locale = $context->getLocale();

		$values['order.siteid'] = $locale->getSiteId();
		$price = \Aimeos\MShop::create( $context, 'price' )->createItem( [
			'price.currencyid' => $values['order.currencyid'] ?? null,
			'price.value' => $values['order.price'] ?? '0.00',
			'price.costs' => $values['order.costs'] ?? '0.00',
			'price.rebate' => $values['order.rebate'] ?? '0.00',
			'price.taxflag' => $values['order.taxflag'] ?? '0.00',
			'price.taxrates' => $values['order.taxrates'] ?? [],
			'price.tax' => $values['order.tax'] ?? null,
		] );

		$order = $this->createItemBase( $price, clone $locale, $values );

		\Aimeos\MShop::create( $context, 'plugin' )->register( $order, 'order' );

		return $order;
	}


	/**
	 * Creates a search critera object
	 *
	 * @param boolean $default Add default criteria (optional)
	 * @return \Aimeos\MW\Criteria\Iface New search criteria object
	 */
	public function createSearch( $default = false )
	{
		$search = parent::createSearch();

		if( $default === true )
		{
			$search->setConditions( $search->combine( '&&', [
				$search->compare( '==', 'order.customerid', $this->getContext()->getUserId() ),
				$search->getConditions()
			] ) );
		}

		return $search;
	}


	/**
	 * Creates a one-time order in the storage from the given invoice object.
	 *
	 * @param \Aimeos\MShop\Order\Item\Iface $item Order item with necessary values
	 * @param boolean $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Order\Item\Iface $item Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Order\Item\Iface $item, $fetch = true )
	{
		if( !$item->isModified() )
		{
			$this->storeAddresses( $item );
			$this->storeProducts( $item );
			$this->storeServices( $item );
			$this->storeCoupons( $item );

			return $item;
		}

		$context = $this->getContext();

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$id = $item->getId();
			$date = date( 'Y-m-d H:i:s' );
			$columns = $this->getObject()->getSaveAttributes();

			if( $id === null )
			{
				/** mshop/order/manager/standard/insert/mysql
				 * Inserts a new order record into the database table
				 *
				 * @see mshop/order/manager/standard/insert/ansi
				 */

				/** mshop/order/manager/standard/insert/ansi
				 * Inserts a new order record into the database table
				 *
				 * Items with no ID yet (i.e. the ID is NULL) will be created in
				 * the database and the newly created ID retrieved afterwards
				 * using the "newid" SQL statement.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the order item to the statement before they are
				 * sent to the database server. The number of question marks must
				 * be the same as the number of columns listed in the INSERT
				 * statement. The order of the columns must correspond to the
				 * order in the saveItems() method, so the correct values are
				 * bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for inserting records
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/order/manager/standard/update/ansi
				 * @see mshop/order/manager/standard/newid/ansi
				 * @see mshop/order/manager/standard/delete/ansi
				 * @see mshop/order/manager/standard/search/ansi
				 * @see mshop/order/manager/standard/count/ansi
				 */
				$path = 'mshop/order/manager/standard/insert';
				$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ) );
			}
			else
			{
				/** mshop/order/manager/standard/update/mysql
				 * Updates an existing order record in the database
				 *
				 * @see mshop/order/manager/standard/update/ansi
				 */

				/** mshop/order/manager/standard/update/ansi
				 * Updates an existing order record in the database
				 *
				 * Items which already have an ID (i.e. the ID is not NULL) will
				 * be updated in the database.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the order item to the statement before they are
				 * sent to the database server. The order of the columns must
				 * correspond to the order in the saveItems() method, so the
				 * correct values are bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for updating records
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/order/manager/standard/insert/ansi
				 * @see mshop/order/manager/standard/newid/ansi
				 * @see mshop/order/manager/standard/delete/ansi
				 * @see mshop/order/manager/standard/search/ansi
				 * @see mshop/order/manager/standard/count/ansi
				 */
				$path = 'mshop/order/manager/standard/update';
				$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ), false );
			}

			$priceItem = $item->getPrice();
			$localeItem = $context->getLocale();

			$idx = 1;
			$stmt = $this->getCachedStatement( $conn, $path, $sql );

			foreach( $columns as $name => $entry ) {
				$stmt->bind( $idx++, $item->get( $name ), $entry->getInternalType() );
			}

			$stmt->bind( $idx++, $item->getType() );
			$stmt->bind( $idx++, $item->getDatePayment() );
			$stmt->bind( $idx++, $item->getDateDelivery() );
			$stmt->bind( $idx++, $item->getDeliveryStatus(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, $item->getPaymentStatus(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, $item->getRelatedId(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, $item->getCustomerId() );
			$stmt->bind( $idx++, $localeItem->getSite()->getCode() );
			$stmt->bind( $idx++, $item->getLocale()->getLanguageId() );
			$stmt->bind( $idx++, $priceItem->getCurrencyId() );
			$stmt->bind( $idx++, $priceItem->getValue() );
			$stmt->bind( $idx++, $priceItem->getCosts() );
			$stmt->bind( $idx++, $priceItem->getRebate() );
			$stmt->bind( $idx++, $priceItem->getTaxValue() );
			$stmt->bind( $idx++, $priceItem->getTaxFlag(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, $item->getCustomerReference() );
			$stmt->bind( $idx++, $item->getComment() );
			$stmt->bind( $idx++, $date ); // mtime
			$stmt->bind( $idx++, $context->getEditor() );
			$stmt->bind( $idx++, $context->getLocale()->getSiteId(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );

			if( $id !== null ) {
				$stmt->bind( $idx++, $id, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
				$item->setId( $id ); // is not modified anymore
			} else {
				$stmt->bind( $idx++, $date ); // ctime
				$stmt->bind( $idx++, date( 'Y-m-d' ) ); // cdate
				$stmt->bind( $idx++, date( 'Y-m' ) ); // cmonth
				$stmt->bind( $idx++, date( 'Y-W' ) ); // cweek
				$stmt->bind( $idx++, date( 'w' ) ); // cwday
				$stmt->bind( $idx++, date( 'H' ) ); // chour
			}

			$stmt->execute()->finish();

			if( $id === null && $fetch === true )
			{
				/** mshop/order/manager/standard/newid/mysql
				 * Retrieves the ID generated by the database when inserting a new record
				 *
				 * @see mshop/order/manager/standard/newid/ansi
				 */

				/** mshop/order/manager/standard/newid/ansi
				 * Retrieves the ID generated by the database when inserting a new record
				 *
				 * As soon as a new record is inserted into the database table,
				 * the database server generates a new and unique identifier for
				 * that record. This ID can be used for retrieving, updating and
				 * deleting that specific record from the table again.
				 *
				 * For MySQL:
				 *  SELECT LAST_INSERT_ID()
				 * For PostgreSQL:
				 *  SELECT currval('seq_mord_id')
				 * For SQL Server:
				 *  SELECT SCOPE_IDENTITY()
				 * For Oracle:
				 *  SELECT "seq_mord_id".CURRVAL FROM DUAL
				 *
				 * There's no way to retrive the new ID by a SQL statements that
				 * fits for most database servers as they implement their own
				 * specific way.
				 *
				 * @param string SQL statement for retrieving the last inserted record ID
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/order/manager/standard/insert/ansi
				 * @see mshop/order/manager/standard/update/ansi
				 * @see mshop/order/manager/standard/delete/ansi
				 * @see mshop/order/manager/standard/search/ansi
				 * @see mshop/order/manager/standard/count/ansi
				 */
				$path = 'mshop/order/manager/standard/newid';
				$item->setId( $this->newId( $conn, $path ) );
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}


		$this->addStatus( $item );

		$this->storeAddresses( $item );
		$this->storeProducts( $item );
		$this->storeServices( $item );
		$this->storeCoupons( $item );

		return $item;
	}


	/**
	 * Returns an order invoice item built from database values.
	 *
	 * @param string $id Unique id of the order invoice
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param boolean $default Add default criteria
	 * @return \Aimeos\MShop\Order\Item\Iface Returns order invoice item of the given id
	 * @throws \Aimeos\MShop\Order\Exception If item couldn't be found
	 */
	public function getItem( $id, array $ref = [], $default = false )
	{
		return $this->getItemBase( 'order.id', $id, $ref, $default );
	}


	/**
	 * Removes multiple items.
	 *
	 * @param \Aimeos\MShop\Common\Item\Iface[]|string[] $itemIds List of item objects or IDs of the items
	 * @return \Aimeos\MShop\Order\Manager\Iface Manager object for chaining method calls
	 */
	public function deleteItems( array $itemIds )
	{
		/** mshop/order/manager/standard/delete/mysql
		 * Deletes the items matched by the given IDs from the database
		 *
		 * @see mshop/order/manager/standard/delete/ansi
		 */

		/** mshop/order/manager/standard/delete/ansi
		 * Deletes the items matched by the given IDs from the database
		 *
		 * Removes the records specified by the given IDs from the order database.
		 * The records must be from the site that is configured via the
		 * context item.
		 *
		 * The ":cond" placeholder is replaced by the name of the ID column and
		 * the given ID or list of IDs while the site ID is bound to the question
		 * mark.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for deleting items
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/order/manager/standard/insert/ansi
		 * @see mshop/order/manager/standard/update/ansi
		 * @see mshop/order/manager/standard/newid/ansi
		 * @see mshop/order/manager/standard/search/ansi
		 * @see mshop/order/manager/standard/count/ansi
		 */
		$path = 'mshop/order/manager/standard/delete';

		return $this->deleteItemsBase( $itemIds, $path );
	}


	/**
	 * Returns the available manager types
	 *
	 * @param boolean $withsub Return also the resource type of sub-managers if true
	 * @return string[] Type of the manager and submanagers, subtypes are separated by slashes
	 */
	public function getResourceType( $withsub = true )
	{
		$path = 'mshop/order/manager/submanagers';
		$ref = ['address', 'coupon', 'product', 'service', 'status'];

		return $this->getResourceTypeBase( 'order', $path, $ref, $withsub );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return \Aimeos\MW\Criteria\Attribute\Iface[] List of search attribute items
	 */
	public function getSearchAttributes( $withsub = true )
	{
		/** mshop/order/manager/submanagers
		 * List of manager names that can be instantiated by the order manager
		 *
		 * Managers provide a generic interface to the underlying storage.
		 * Each manager has or can have sub-managers caring about particular
		 * aspects. Each of these sub-managers can be instantiated by its
		 * parent manager using the getSubManager() method.
		 *
		 * The search keys from sub-managers can be normally used in the
		 * manager as well. It allows you to search for items of the manager
		 * using the search keys of the sub-managers to further limit the
		 * retrieved list of items.
		 *
		 * @param array List of sub-manager names
		 * @since 2014.03
		 * @category Developer
		 */
		$path = 'mshop/order/manager/submanagers';
		$default = ['address', 'coupon', 'product', 'service', 'status'];

		return $this->getSearchAttributesBase( $this->searchConfig, $path, $default, $withsub );
	}


	/**
	 * Searches for orders based on the given criteria.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Search criteria object
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param integer|null &$total Number of items that are available in total
	 * @return \Aimeos\MShop\Order\Item\Iface[] List of order items
	 */
	public function searchItems( \Aimeos\MW\Criteria\Iface $search, array $ref = [], &$total = null )
	{
		$map = [];

		$context = $this->getContext();
		$priceManager = \Aimeos\MShop::create( $context, 'price' );
		$localeManager = \Aimeos\MShop::create( $context, 'locale' );

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$required = array( 'order' );

			/** mshop/order/manager/sitemode
			 * Mode how items from levels below or above in the site tree are handled
			 *
			 * By default, only items from the current site are fetched from the
			 * storage. If the ai-sites extension is installed, you can create a
			 * tree of sites. Then, this setting allows you to define for the
			 * whole order domain if items from parent sites are inherited,
			 * sites from child sites are aggregated or both.
			 *
			 * Available constants for the site mode are:
			 * * 0 = only items from the current site
			 * * 1 = inherit items from parent sites
			 * * 2 = aggregate items from child sites
			 * * 3 = inherit and aggregate items at the same time
			 *
			 * You also need to set the mode in the locale manager
			 * (mshop/locale/manager/standard/sitelevel) to one of the constants.
			 * If you set it to the same value, it will work as described but you
			 * can also use different modes. For example, if inheritance and
			 * aggregation is configured the locale manager but only inheritance
			 * in the domain manager because aggregating items makes no sense in
			 * this domain, then items wil be only inherited. Thus, you have full
			 * control over inheritance and aggregation in each domain.
			 *
			 * @param integer Constant from Aimeos\MShop\Locale\Manager\Base class
			 * @category Developer
			 * @since 2018.01
			 * @see mshop/locale/manager/standard/sitelevel
			 */
			$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
			$level = $context->getConfig()->get( 'mshop/order/manager/sitemode', $level );

			/** mshop/order/manager/standard/search/mysql
			 * Retrieves the records matched by the given criteria in the database
			 *
			 * @see mshop/order/manager/standard/search/ansi
			 */

			/** mshop/order/manager/standard/search/ansi
			 * Retrieves the records matched by the given criteria in the database
			 *
			 * Fetches the records matched by the given criteria from the order
			 * database. The records must be from one of the sites that are
			 * configured via the context item. If the current site is part of
			 * a tree of sites, the SELECT statement can retrieve all records
			 * from the current site and the complete sub-tree of sites.
			 *
			 * As the records can normally be limited by criteria from sub-managers,
			 * their tables must be joined in the SQL context. This is done by
			 * using the "internaldeps" property from the definition of the ID
			 * column of the sub-managers. These internal dependencies specify
			 * the JOIN between the tables and the used columns for joining. The
			 * ":joins" placeholder is then replaced by the JOIN strings from
			 * the sub-managers.
			 *
			 * To limit the records matched, conditions can be added to the given
			 * criteria object. It can contain comparisons like column names that
			 * must match specific values which can be combined by AND, OR or NOT
			 * operators. The resulting string of SQL conditions replaces the
			 * ":cond" placeholder before the statement is sent to the database
			 * server.
			 *
			 * If the records that are retrieved should be ordered by one or more
			 * columns, the generated string of column / sort direction pairs
			 * replaces the ":order" placeholder. In case no ordering is required,
			 * the complete ORDER BY part including the "\/*-orderby*\/...\/*orderby-*\/"
			 * markers is removed to speed up retrieving the records. Columns of
			 * sub-managers can also be used for ordering the result set but then
			 * no index can be used.
			 *
			 * The number of returned records can be limited and can start at any
			 * number between the begining and the end of the result set. For that
			 * the ":size" and ":start" placeholders are replaced by the
			 * corresponding values from the criteria object. The default values
			 * are 0 for the start and 100 for the size value.
			 *
			 * The SQL statement should conform to the ANSI standard to be
			 * compatible with most relational database systems. This also
			 * includes using double quotes for table and column names.
			 *
			 * @param string SQL statement for searching items
			 * @since 2014.03
			 * @category Developer
			 * @see mshop/order/manager/standard/insert/ansi
			 * @see mshop/order/manager/standard/update/ansi
			 * @see mshop/order/manager/standard/newid/ansi
			 * @see mshop/order/manager/standard/delete/ansi
			 * @see mshop/order/manager/standard/count/ansi
			 */
			$cfgPathSearch = 'mshop/order/manager/standard/search';

			/** mshop/order/manager/standard/count/mysql
			 * Counts the number of records matched by the given criteria in the database
			 *
			 * @see mshop/order/manager/standard/count/ansi
			 */

			/** mshop/order/manager/standard/count/ansi
			 * Counts the number of records matched by the given criteria in the database
			 *
			 * Counts all records matched by the given criteria from the order
			 * database. The records must be from one of the sites that are
			 * configured via the context item. If the current site is part of
			 * a tree of sites, the statement can count all records from the
			 * current site and the complete sub-tree of sites.
			 *
			 * As the records can normally be limited by criteria from sub-managers,
			 * their tables must be joined in the SQL context. This is done by
			 * using the "internaldeps" property from the definition of the ID
			 * column of the sub-managers. These internal dependencies specify
			 * the JOIN between the tables and the used columns for joining. The
			 * ":joins" placeholder is then replaced by the JOIN strings from
			 * the sub-managers.
			 *
			 * To limit the records matched, conditions can be added to the given
			 * criteria object. It can contain comparisons like column names that
			 * must match specific values which can be combined by AND, OR or NOT
			 * operators. The resulting string of SQL conditions replaces the
			 * ":cond" placeholder before the statement is sent to the database
			 * server.
			 *
			 * Both, the strings for ":joins" and for ":cond" are the same as for
			 * the "search" SQL statement.
			 *
			 * Contrary to the "search" statement, it doesn't return any records
			 * but instead the number of records that have been found. As counting
			 * thousands of records can be a long running task, the maximum number
			 * of counted records is limited for performance reasons.
			 *
			 * The SQL statement should conform to the ANSI standard to be
			 * compatible with most relational database systems. This also
			 * includes using double quotes for table and column names.
			 *
			 * @param string SQL statement for counting items
			 * @since 2014.03
			 * @category Developer
			 * @see mshop/order/manager/standard/insert/ansi
			 * @see mshop/order/manager/standard/update/ansi
			 * @see mshop/order/manager/standard/newid/ansi
			 * @see mshop/order/manager/standard/delete/ansi
			 * @see mshop/order/manager/standard/search/ansi
			 */
			$cfgPathCount = 'mshop/order/manager/standard/count';

			$results = $this->searchItemsBase( $conn, $search, $cfgPathSearch, $cfgPathCount,
				$required, $total, $level );

			try
			{
				while( ( $row = $results->fetch() ) !== false )
				{
					$price = $priceManager->createItem( [
						'price.currencyid' => $row['order.currencyid'],
						'price.value' => $row['order.price'],
						'price.costs' => $row['order.costs'],
						'price.rebate' => $row['order.rebate'],
						'price.tax' => $row['order.tax'],
						'price.taxflag' => $row['order.taxflag'],
					] );

					// you may need the site object! take care!
					$locale = $localeManager->createItem( [
						'locale.languageid' => $row['order.languageid'],
						'locale.currencyid' => $row['order.currencyid'],
						'locale.siteid' => $row['order.siteid'],
					] );

					$map[(string) $row['order.id']] = [$price, $locale, $row];
				}
			}
			catch( \Exception $e )
			{
				$results->finish();
				throw $e;
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		return $this->buildItems( $map, $ref );
	}


	/**
	 * Returns a new manager for order extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions, e.g base, etc.
	 */
	public function getSubManager( $manager, $name = null )
	{
		return $this->getSubManagerBase( 'order', $manager, $name );
	}


	/**
	 * Adds the new payment and delivery values to the order status log.
	 *
	 * @param \Aimeos\MShop\Order\Item\Iface $item Order item object
	 */
	protected function addStatus( \Aimeos\MShop\Order\Item\Iface $item )
	{
		$statusManager = \Aimeos\MShop::create( $this->getContext(), 'order/status' );

		$statusItem = $statusManager->createItem();
		$statusItem->setParentId( $item->getId() );

		if( ( $status = $item->get( '.statuspayment' ) ) !== null && $status != $item->getPaymentStatus() )
		{
			$statusItem->setId( null )->setValue( $item->getPaymentStatus() )
				->setType( \Aimeos\MShop\Order\Item\Status\Base::STATUS_PAYMENT );

			$statusManager->saveItem( $statusItem, false );
		}

		if( ( $status = $item->get( '.statusdelivery' ) ) !== null && $status != $item->getDeliveryStatus() )
		{
			$statusItem->setId( null )->setValue( $item->getDeliveryStatus() )
				->setType( \Aimeos\MShop\Order\Item\Status\Base::STATUS_DELIVERY );

			$statusManager->saveItem( $statusItem, false );
		}
	}


	/**
	 * Creates a new basket containing the items from the order excluding the coupons.
	 * If the last parameter is ture, the items will be marked as new and
	 * modified so an additional order is stored when the basket is saved.
	 *
	 * @param string $id Base ID of the order to load
	 * @param integer $parts Bitmap of the basket parts that should be loaded
	 * @param boolean $fresh Create a new basket by copying the existing one and remove IDs
	 * @param boolean $default True to use default criteria, false for no limitation
	 * @return \Aimeos\MShop\Order\Item\Iface Basket including all items
	 */
	public function load( $id, $parts = \Aimeos\MShop\Order\Item\Base::PARTS_ALL, $fresh = false, $default = false )
	{
		$search = $this->getObject()->createSearch( $default );
		$expr = [
			$search->compare( '==', 'order.id', $id ),
			$search->getConditions(),
		];
		$search->setConditions( $search->combine( '&&', $expr ) );

		$context = $this->getContext();
		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$sitelevel = \Aimeos\MShop\Locale\Manager\Base::SITE_SUBTREE;
			$cfgPathSearch = 'mshop/order/manager/standard/search';
			$cfgPathCount = 'mshop/order/manager/standard/count';
			$required = array( 'order' );
			$total = null;

			$results = $this->searchItemsBase( $conn, $search, $cfgPathSearch, $cfgPathCount, $required, $total, $sitelevel );

			if( ( $row = $results->fetch() ) === false ) {
				throw new \Aimeos\MShop\Order\Exception( sprintf( 'Order item with order ID "%1$s" not found', $id ) );
			}
			$results->finish();

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		$priceManager = \Aimeos\MShop::create( $context, 'price' );
		$localeManager = \Aimeos\MShop::create( $context, 'locale' );

		$price = $priceManager->createItem( [
			'price.currencyid' => $row['order.currencyid'],
			'price.value' => $row['order.price'],
			'price.costs' => $row['order.costs'],
			'price.rebate' => $row['order.rebate'],
			'price.tax' => $row['order.tax'],
			'price.taxflag' => $row['order.taxflag'],
		] );

		// you may need the site object! take care!
		$localeItem = $localeManager->createItem( [
			'locale.languageid' => $row['order.languageid'],
			'locale.currencyid' => $row['order.currencyid'],
			'locale.siteid' => $row['order.siteid'],
		] );

		if( $fresh === false ) {
			$basket = $this->loadItems( $id, $price, $localeItem, $row, $parts );
		} else {
			$basket = $this->loadFresh( $id, $price, $localeItem, $row, $parts );
		}

		$pluginManager = \Aimeos\MShop::create( $this->getContext(), 'plugin' );
		$pluginManager->register( $basket, 'order' );

		return $basket;
	}


	/**
	 * Saves the complete basket to the storage including the items attached.
	 *
	 * @param \Aimeos\MShop\Order\Item\Iface $basket Basket object containing all information
	 * @param integer $parts Bitmap of the basket parts that should be stored
	 * @return \Aimeos\MShop\Order\Item\Iface Stored order basket
	 */
	public function store( \Aimeos\MShop\Order\Item\Iface $basket, $parts = \Aimeos\MShop\Order\Item\Base::PARTS_ALL )
	{
		$basket = $this->getObject()->saveItem( $basket );

		if( $parts & \Aimeos\MShop\Order\Item\Base::PARTS_PRODUCT
			|| $parts & \Aimeos\MShop\Order\Item\Base::PARTS_COUPON
		) {
			$this->storeProducts( $basket );
		}

		if( $parts & \Aimeos\MShop\Order\Item\Base::PARTS_COUPON ) {
			$this->storeCoupons( $basket );
		}

		if( $parts & \Aimeos\MShop\Order\Item\Base::PARTS_ADDRESS ) {
			$this->storeAddresses( $basket );
		}

		if( $parts & \Aimeos\MShop\Order\Item\Base::PARTS_SERVICE ) {
			$this->storeServices( $basket );
		}

		return $basket;
	}


	/**
	 * Creates the order item objects from the map and adds the referenced items
	 *
	 * @param array $map Associative list of order IDs as keys and list of price/locale/row as values
	 * @param string[] $ref Domain items that should be added as well, e.g.
	 *	"order/address", "order/coupon", "order/product", "order/service"
	 * @return \Aimeos\MShop\Order\Item\Iface[] Associative list of order IDs as keys and items as values
	 */
	protected function buildItems( array $map, array $ref )
	{
		$items = [];
		$orderIds = array_keys( $map );
		$addressMap = $couponMap = $productMap = $serviceMap = [];

		if( in_array( 'order/address', $ref ) ) {
			$addressMap = $this->getAddresses( $orderIds );
		}

		if( in_array( 'order/product', $ref ) ) {
			$productMap = $this->getProducts( $orderIds );
		}

		if( in_array( 'order/coupon', $ref ) ) {
			$couponMap = $this->getCoupons( $orderIds, false, $productMap );
		}

		if( in_array( 'order/service', $ref ) ) {
			$serviceMap = $this->getServices( $orderIds );
		}

		foreach( $map as $id => $list )
		{
			list( $price, $locale, $row ) = $list;
			$addresses = $coupons = $products = $services = [];

			if( isset( $addressMap[$id] ) ) {
				$addresses = $addressMap[$id];
			}

			if( isset( $couponMap[$id] ) ) {
				$coupons = $couponMap[$id];
			}

			if( isset( $productMap[$id] ) ) {
				$products = $productMap[$id];
			}

			if( isset( $serviceMap[$id] ) ) {
				$services = $serviceMap[$id];
			}

			$items[$id] = $this->createItemBase( $price, $locale, $row, $products, $addresses, $services, $coupons );
		}

		return $items;
	}


	/**
	 * Returns a new and empty order item (shopping basket).
	 *
	 * @param \Aimeos\MShop\Price\Item\Iface $price Default price of the basket (usually 0.00)
	 * @param \Aimeos\MShop\Locale\Item\Iface $locale Locale item containing the site, language and currency
	 * @param array $values Associative list of key/value pairs containing, e.g. the order or user ID
	 * @param \Aimeos\MShop\Order\Item\Product\Iface[] $products List of ordered product items
	 * @param \Aimeos\MShop\Order\Item\Address\Iface[] $addresses List of order address items
	 * @param \Aimeos\MShop\Order\Item\Service\Iface[] $services List of order serviceitems
	 * @param \Aimeos\MShop\Order\Item\Product\Iface[] $coupons Associative list of coupon codes as keys and items as values
	 * @return \Aimeos\MShop\Order\Item\Iface Order object
	 */
	protected function createItemBase( \Aimeos\MShop\Price\Item\Iface $price, \Aimeos\MShop\Locale\Item\Iface $locale,
		array $values = [], array $products = [], array $addresses = [],
		array $services = [], array $coupons = [] )
	{
		return new \Aimeos\MShop\Order\Item\Standard( $price, $locale,
			$values, $products, $addresses, $services, $coupons );
	}
}
