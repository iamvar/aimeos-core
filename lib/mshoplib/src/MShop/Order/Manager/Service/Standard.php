<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Order
 */


namespace Aimeos\MShop\Order\Manager\Service;


/**
 * Default Manager Order service
 *
 * @package MShop
 * @subpackage Order
 */
class Standard
	extends \Aimeos\MShop\Common\Manager\Base
	implements \Aimeos\MShop\Order\Manager\Service\Iface, \Aimeos\MShop\Common\Manager\Factory\Iface
{
	private $searchConfig = array(
		'order.service.id' => array(
			'code' => 'order.service.id',
			'internalcode' => ' mordse."id"',
			'internaldeps' => array( 'LEFT JOIN "mshop_order_service" AS  mordse ON (  mord."id" =  mordse."orderid" )' ),
			'label' => 'Service ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'order.service.siteid' => array(
			'code' => 'order.service.siteid',
			'internalcode' => ' mordse."siteid"',
			'label' => 'Service site ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'order.service.orderid' => array(
			'code' => 'order.service.orderid',
			'internalcode' => ' mordse."orderid"',
			'label' => 'Order ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'order.service.serviceid' => array(
			'code' => 'order.service.serviceid',
			'internalcode' => ' mordse."servid"',
			'label' => 'Service original service ID',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.service.name' => array(
			'code' => 'order.service.name',
			'internalcode' => ' mordse."name"',
			'label' => 'Service name',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.service.code' => array(
			'code' => 'order.service.code',
			'internalcode' => ' mordse."code"',
			'label' => 'Service code',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.service.type' => array(
			'code' => 'order.service.type',
			'internalcode' => ' mordse."type"',
			'label' => 'Service type',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.service.currencyid' => array(
			'code' => 'order.service.currencyid',
			'internalcode' => ' mordse."currencyid"',
			'label' => 'Service currencyid code',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.service.price' => array(
			'code' => 'order.service.price',
			'internalcode' => ' mordse."price"',
			'label' => 'Service price',
			'type' => 'decimal',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.service.costs' => array(
			'code' => 'order.service.costs',
			'internalcode' => ' mordse."costs"',
			'label' => 'Service shipping',
			'type' => 'decimal',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.service.rebate' => array(
			'code' => 'order.service.rebate',
			'internalcode' => ' mordse."rebate"',
			'label' => 'Service rebate',
			'type' => 'decimal',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.service.taxrates' => array(
			'code' => 'order.service.taxrates',
			'internalcode' => ' mordse."taxrate"',
			'label' => 'Service taxrates',
			'type' => 'decimal',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.service.tax' => array(
			'code' => 'order.service.tax',
			'internalcode' => ' mordse."tax"',
			'label' => 'Service tax value',
			'type' => 'decimal',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'order.service.taxflag' => array(
			'code' => 'order.service.taxflag',
			'internalcode' => ' mordse."taxflag"',
			'label' => 'Service tax flag (0=net, 1=gross)',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'order.service.mediaurl' => array(
			'code' => 'order.service.mediaurl',
			'internalcode' => ' mordse."mediaurl"',
			'label' => 'Service media url',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.service.position' => array(
			'code' => 'order.service.position',
			'internalcode' => ' mordse."pos"',
			'label' => 'Service position',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'order.service.ctime' => array(
			'code' => 'order.service.ctime',
			'internalcode' => ' mordse."ctime"',
			'label' => 'Service create date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.service.mtime' => array(
			'code' => 'order.service.mtime',
			'internalcode' => ' mordse."mtime"',
			'label' => 'Service modify date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'order.service.editor' => array(
			'code' => 'order.service.editor',
			'internalcode' => ' mordse."editor"',
			'label' => 'Service editor',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
	);


	/**
	 * Initializes the object.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );
		$this->setResourceName( 'db-order' );
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
		/** mshop/order/manager/service/standard/aggregate/mysql
		 * Counts the number of records grouped by the values in the key column and matched by the given criteria
		 *
		 * @see mshop/order/manager/service/standard/aggregate/ansi
		 */

		/** mshop/order/manager/service/standard/aggregate/ansi
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
		 * @see mshop/order/manager/service/standard/insert/ansi
		 * @see mshop/order/manager/service/standard/update/ansi
		 * @see mshop/order/manager/service/standard/newid/ansi
		 * @see mshop/order/manager/service/standard/delete/ansi
		 * @see mshop/order/manager/service/standard/search/ansi
		 * @see mshop/order/manager/service/standard/count/ansi
		 */

		/** mshop/order/manager/service/standard/aggregateavg/mysql
		 * Computes the average of all values grouped by the key column and matched by the given criteria
		 *
		 * @param string SQL statement for aggregating the order service items and computing the average value
		 * @since 2017.10
		 * @category Developer
		 * @see mshop/order/manager/service/standard/aggregateavg/ansi
		 * @see mshop/order/manager/service/standard/aggregate/mysql
		 */

		/** mshop/order/manager/service/standard/aggregateavg/ansi
		 * Computes the average of all values grouped by the key column and matched by the given criteria
		 *
		 * @param string SQL statement for aggregating the order service items and computing the average value
		 * @since 2017.10
		 * @category Developer
		 * @see mshop/order/manager/service/standard/aggregate/ansi
		 */

		/** mshop/order/manager/service/standard/aggregatesum/mysql
		 * Computes the sum of all values grouped by the key column and matched by the given criteria
		 *
		 * @param string SQL statement for aggregating the order service items and computing the sum
		 * @since 2017.10
		 * @category Developer
		 * @see mshop/order/manager/service/standard/aggregatesum/ansi
		 * @see mshop/order/manager/service/standard/aggregate/mysql
		 */

		/** mshop/order/manager/service/standard/aggregatesum/ansi
		 * Computes the sum of all values grouped by the key column and matched by the given criteria
		 *
		 * @param string SQL statement for aggregating the order service items and computing the sum
		 * @since 2017.10
		 * @category Developer
		 * @see mshop/order/manager/service/standard/aggregate/ansi
		 */

		$cfgkey = 'mshop/order/manager/service/standard/aggregate' . $type;
		return $this->aggregateBase( $search, $key, $cfgkey, array( 'order.service' ), $value );
	}


	/**
	 * Removes old entries from the storage.
	 *
	 * @param string[] $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Order\Manager\Service\Iface Manager object for chaining method calls
	 */
	public function clear( array $siteids )
	{
		$path = 'mshop/order/manager/service/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, array( 'attribute' ) ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/order/manager/service/standard/delete' );
	}


	/**
	 * Creates a new empty item instance
	 *
	 * @param array $values Values the item should be initialized with
	 * @return \Aimeos\MShop\Order\Item\Service\Iface New order service item object
	 */
	public function createItem( array $values = [] )
	{
		$context = $this->getContext();
		$values['order.service.siteid'] = $context->getLocale()->getSiteId();

		$price = \Aimeos\MShop::create( $context, 'price' )->createItem( [
			'price.currencyid' => $values['order.service.currencyid'] ?? null,
			'price.value' => $values['order.service.price'] ?? '0.00',
			'price.costs' => $values['order.service.costs'] ?? '0.00',
			'price.rebate' => $values['order.service.rebate'] ?? '0.00',
			'price.taxrates' => $values['order.service.taxrates'] ?? [],
			'price.taxflag' => $values['order.service.taxflag'] ?? 0,
			'price.tax' => $values['order.service.tax'] ?? null,
		] );

		return $this->createItemBase( $price, $values );
	}


	/**
	 * Creates a new service attribute item object
	 *
	 * @param array $values Values the item should be initialized with
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface New service attribute item object
	 */
	public function createAttributeItem( array $values = [] )
	{
		return $this->getSubManager( 'attribute' )->createItem( $values );
	}


	/**
	 * Creates a search critera object
	 *
	 * @param boolean $default Add default criteria (optional)
	 * @return \Aimeos\MW\Criteria\Iface New search criteria object
	 */
	public function createSearch( $default = false )
	{
		$search = parent::createSearch( $default );
		$search->setSortations( [$search->sort( '+', 'order.service.id' )] );

		return $search;
	}


	/**
	 * Removes multiple items.
	 *
	 * @param \Aimeos\MShop\Common\Item\Iface[]|string[] $itemIds List of item objects or IDs of the items
	 * @return \Aimeos\MShop\Order\Manager\Service\Iface Manager object for chaining method calls
	 */
	public function deleteItems( array $itemIds )
	{
		/** mshop/order/manager/service/standard/delete/mysql
		 * Deletes the items matched by the given IDs from the database
		 *
		 * @see mshop/order/manager/service/standard/delete/ansi
		 */

		/** mshop/order/manager/service/standard/delete/ansi
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
		 * @see mshop/order/manager/service/standard/insert/ansi
		 * @see mshop/order/manager/service/standard/update/ansi
		 * @see mshop/order/manager/service/standard/newid/ansi
		 * @see mshop/order/manager/service/standard/search/ansi
		 * @see mshop/order/manager/service/standard/count/ansi
		 */
		$path = 'mshop/order/manager/service/standard/delete';

		return $this->deleteItemsBase( $itemIds, $path );
	}


	/**
	 * Returns the order service item object for the given ID.
	 *
	 * @param string $id Order service ID
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param boolean $default Add default criteria
	 * @return \Aimeos\MShop\Order\Item\Service\Iface Returns order service item of the given id
	 * @throws \Aimeos\MShop\Exception If item couldn't be found
	 */
	public function getItem( $id, array $ref = [], $default = false )
	{
		return $this->getItemBase( 'order.service.id', $id, $ref, $default );
	}


	/**
	 * Returns the available manager types
	 *
	 * @param boolean $withsub Return also the resource type of sub-managers if true
	 * @return string[] Type of the manager and submanagers, subtypes are separated by slashes
	 */
	public function getResourceType( $withsub = true )
	{
		$path = 'mshop/order/manager/service/submanagers';
		return $this->getResourceTypeBase( 'order/service', $path, array( 'attribute' ), $withsub );
	}


	/**
	 * Returns the search attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return \Aimeos\MW\Criteria\Attribute\Iface[] List of search attribute items
	 */
	public function getSearchAttributes( $withsub = true )
	{
		/** mshop/order/manager/service/submanagers
		 * List of manager names that can be instantiated by the order service manager
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
		$path = 'mshop/order/manager/service/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, array( 'attribute' ), $withsub );
	}


	/**
	 * Returns a new manager for order service extensions.
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation (from configuration or "Standard" if null)
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions, e.g attribute
	 */
	public function getSubManager( $manager, $name = null )
	{
		/** mshop/order/manager/service/name
		 * Class name of the used order service manager implementation
		 *
		 * Each default order service manager can be replaced by an alternative imlementation.
		 * To use this implementation, you have to set the last part of the class
		 * name as configuration value so the manager factory knows which class it
		 * has to instantiate.
		 *
		 * For example, if the name of the default class is
		 *
		 *  \Aimeos\MShop\Order\Manager\Service\Standard
		 *
		 * and you want to replace it with your own version named
		 *
		 *  \Aimeos\MShop\Order\Manager\Service\Myservice
		 *
		 * then you have to set the this configuration option:
		 *
		 *  mshop/order/manager/service/name = Myservice
		 *
		 * The value is the last part of your own class name and it's case sensitive,
		 * so take care that the configuration value is exactly named like the last
		 * part of the class name.
		 *
		 * The allowed characters of the class name are A-Z, a-z and 0-9. No other
		 * characters are possible! You should always start the last part of the class
		 * name with an upper case character and continue only with lower case characters
		 * or numbers. Avoid chamel case names like "MyService"!
		 *
		 * @param string Last part of the class name
		 * @since 2014.03
		 * @category Developer
		 */

		/** mshop/order/manager/service/decorators/excludes
		 * Excludes decorators added by the "common" option from the order service manager
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to remove a decorator added via
		 * "mshop/common/manager/decorators/default" before they are wrapped
		 * around the order service manager.
		 *
		 *  mshop/order/manager/service/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("\Aimeos\MShop\Common\Manager\Decorator\*") added via
		 * "mshop/common/manager/decorators/default" for the order service manager.
		 *
		 * @param array List of decorator names
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/common/manager/decorators/default
		 * @see mshop/order/manager/service/decorators/global
		 * @see mshop/order/manager/service/decorators/local
		 */

		/** mshop/order/manager/service/decorators/global
		 * Adds a list of globally available decorators only to the order service manager
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("\Aimeos\MShop\Common\Manager\Decorator\*") around the order
		 * service manager.
		 *
		 *  mshop/order/manager/service/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\MShop\Common\Manager\Decorator\Decorator1" only to the order
		 * service manager.
		 *
		 * @param array List of decorator names
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/common/manager/decorators/default
		 * @see mshop/order/manager/service/decorators/excludes
		 * @see mshop/order/manager/service/decorators/local
		 */

		/** mshop/order/manager/service/decorators/local
		 * Adds a list of local decorators only to the order service manager
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("\Aimeos\MShop\Order\Manager\Service\Decorator\*") around the
		 * order service manager.
		 *
		 *  mshop/order/manager/service/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "\Aimeos\MShop\Order\Manager\Service\Decorator\Decorator2" only
		 * to the order service manager.
		 *
		 * @param array List of decorator names
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/common/manager/decorators/default
		 * @see mshop/order/manager/service/decorators/excludes
		 * @see mshop/order/manager/service/decorators/global
		 */

		return $this->getSubManagerBase( 'order', 'service/' . $manager, $name );
	}


	/**
	 * Adds or updates an order service item to the storage.
	 *
	 * @param \Aimeos\MShop\Order\Item\Service\Iface $item Order service object
	 * @param boolean $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Order\Item\Service\Iface $item Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Order\Item\Service\Iface $item, $fetch = true )
	{
		if( !$item->isModified() ) {
			return $item;
		}

		$context = $this->getContext();

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$id = $item->getId();
			$price = $item->getPrice();
			$date = date( 'Y-m-d H:i:s' );
			$columns = $this->getObject()->getSaveAttributes();

			if( $id === null )
			{
				/** mshop/order/manager/service/standard/insert/mysql
				 * Inserts a new order record into the database table
				 *
				 * @see mshop/order/manager/service/standard/insert/ansi
				 */

				/** mshop/order/manager/service/standard/insert/ansi
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
				 * @see mshop/order/manager/service/standard/update/ansi
				 * @see mshop/order/manager/service/standard/newid/ansi
				 * @see mshop/order/manager/service/standard/delete/ansi
				 * @see mshop/order/manager/service/standard/search/ansi
				 * @see mshop/order/manager/service/standard/count/ansi
				 */
				$path = 'mshop/order/manager/service/standard/insert';
				$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ) );
			}
			else
			{
				/** mshop/order/manager/service/standard/update/mysql
				 * Updates an existing order record in the database
				 *
				 * @see mshop/order/manager/service/standard/update/ansi
				 */

				/** mshop/order/manager/service/standard/update/ansi
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
				 * @see mshop/order/manager/service/standard/insert/ansi
				 * @see mshop/order/manager/service/standard/newid/ansi
				 * @see mshop/order/manager/service/standard/delete/ansi
				 * @see mshop/order/manager/service/standard/search/ansi
				 * @see mshop/order/manager/service/standard/count/ansi
				 */
				$path = 'mshop/order/manager/service/standard/update';
				$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ), false );
			}

			$idx = 1;
			$stmt = $this->getCachedStatement( $conn, $path, $sql );

			foreach( $columns as $name => $entry ) {
				$stmt->bind( $idx++, $item->get( $name ), $entry->getInternalType() );
			}

			$stmt->bind( $idx++, $item->getOrderId(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, $item->getServiceId() );
			$stmt->bind( $idx++, $item->getType() );
			$stmt->bind( $idx++, $item->getCode() );
			$stmt->bind( $idx++, $item->getName() );
			$stmt->bind( $idx++, $item->getMediaUrl() );
			$stmt->bind( $idx++, $price->getCurrencyId() );
			$stmt->bind( $idx++, $price->getValue() );
			$stmt->bind( $idx++, $price->getCosts() );
			$stmt->bind( $idx++, $price->getRebate() );
			$stmt->bind( $idx++, $price->getTaxValue() );
			$stmt->bind( $idx++, json_encode( $price->getTaxRates(), JSON_FORCE_OBJECT ) );
			$stmt->bind( $idx++, $price->getTaxFlag(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, (int) $item->getPosition(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, $date ); // mtime
			$stmt->bind( $idx++, $context->getEditor() );
			$stmt->bind( $idx++, $item->getSiteId(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );

			if( $id !== null ) {
				$stmt->bind( $idx++, $id, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
				$item->setId( $id ); //is not modified anymore
			} else {
				$stmt->bind( $idx++, $date ); // ctime
			}

			$stmt->execute()->finish();

			if( $id === null && $fetch === true )
			{
				/** mshop/order/manager/service/standard/newid/mysql
				 * Retrieves the ID generated by the database when inserting a new record
				 *
				 * @see mshop/order/manager/service/standard/newid/ansi
				 */

				/** mshop/order/manager/service/standard/newid/ansi
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
				 * @see mshop/order/manager/service/standard/insert/ansi
				 * @see mshop/order/manager/service/standard/update/ansi
				 * @see mshop/order/manager/service/standard/delete/ansi
				 * @see mshop/order/manager/service/standard/search/ansi
				 * @see mshop/order/manager/service/standard/count/ansi
				 */
				$path = 'mshop/order/manager/service/standard/newid';
				$item->setId( $this->newId( $conn, $path ) );
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		return $this->saveAttributeItems( $item );
	}


	/**
	 * Searches for order service items based on the given criteria.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Search criteria object
	 * @param string[] $ref List of domains to fetch list items and referenced items for
	 * @param integer|null &$total Number of items that are available in total
	 * @return \Aimeos\MShop\Order\Item\Service\Iface[] List of order service items
	 */
	public function searchItems( \Aimeos\MW\Criteria\Iface $search, array $ref = [], &$total = null )
	{
		$items = [];
		$context = $this->getContext();
		$priceManager = \Aimeos\MShop::create( $context, 'price' );

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$required = array( 'order.service' );

			$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
			$level = $context->getConfig()->get( 'mshop/order/manager/sitemode', $level );

			/** mshop/order/manager/service/standard/search/mysql
			 * Retrieves the records matched by the given criteria in the database
			 *
			 * @see mshop/order/manager/service/standard/search/ansi
			 */

			/** mshop/order/manager/service/standard/search/ansi
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
			 * @see mshop/order/manager/service/standard/insert/ansi
			 * @see mshop/order/manager/service/standard/update/ansi
			 * @see mshop/order/manager/service/standard/newid/ansi
			 * @see mshop/order/manager/service/standard/delete/ansi
			 * @see mshop/order/manager/service/standard/count/ansi
			 */
			$cfgPathSearch = 'mshop/order/manager/service/standard/search';

			/** mshop/order/manager/service/standard/count/mysql
			 * Counts the number of records matched by the given criteria in the database
			 *
			 * @see mshop/order/manager/service/standard/count/ansi
			 */

			/** mshop/order/manager/service/standard/count/ansi
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
			 * @see mshop/order/manager/service/standard/insert/ansi
			 * @see mshop/order/manager/service/standard/update/ansi
			 * @see mshop/order/manager/service/standard/newid/ansi
			 * @see mshop/order/manager/service/standard/delete/ansi
			 * @see mshop/order/manager/service/standard/search/ansi
			 */
			$cfgPathCount = 'mshop/order/manager/service/standard/count';

			$results = $this->searchItemsBase( $conn, $search, $cfgPathSearch, $cfgPathCount,
				$required, $total, $level );

			try
			{
				while( ( $row = $results->fetch() ) !== false )
				{
					if( ( $row['order.service.taxrates'] = json_decode( $config = $row['order.service.taxrates'], true ) ) === null )
					{
						$msg = sprintf( 'Invalid JSON as result of search for ID "%2$s" in "%1$s": %3$s', 'mshop_order_service.taxrates', $row['order.service.id'], $config );
						$this->getContext()->getLogger()->log( $msg, \Aimeos\MW\Logger\Base::WARN );
					}

					$price = $priceManager->createItem( [
						'price.currencyid' => $row['order.service.currencyid'],
						'price.value' => $row['order.service.price'],
						'price.costs' => $row['order.service.costs'],
						'price.rebate' => $row['order.service.rebate'],
						'price.taxflag' => $row['order.service.taxflag'],
						'price.taxrates' => $row['order.service.taxrates'],
						'price.tax' => $row['order.service.tax'],
					] );

					$items[(string) $row['order.service.id']] = array( 'price' => $price, 'item' => $row );
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

		$result = [];
		$attributes = $this->getAttributeItems( array_keys( $items ) );

		foreach( $items as $id => $row )
		{
			$attrList = [];
			if( isset( $attributes[$id] ) ) {
				$attrList = $attributes[$id];
			}
			$result[$id] = $this->createItemBase( $row['price'], $row['item'], $attrList );
		}

		return $result;
	}


	/**
	 * Creates a new order service item object initialized with given parameters.
	 *
	 * @param \Aimeos\MShop\Price\Item\Iface $price Price object
	 * @param array $values Associative list of values from the database
	 * @param \Aimeos\MShop\Order\Item\Service\Attribute\Iface[] $attributes List of order service attribute items
	 * @return \Aimeos\MShop\Order\Item\Service\Iface Order service item
	 */
	protected function createItemBase( \Aimeos\MShop\Price\Item\Iface $price,
		array $values = [], array $attributes = [] )
	{
		return new \Aimeos\MShop\Order\Item\Service\Standard( $price, $values, $attributes );
	}


	/**
	 * Searches for attribute items connected with order service item.
	 *
	 * @param string[] $ids List of order service item IDs
	 * @return array Associative list of order service IDs as keys and order service attribute items
	 *  implementing \Aimeos\MShop\Order\Item\Service\Attribute\Iface as values
	 */
	protected function getAttributeItems( $ids )
	{
		$manager = $this->getObject()->getSubManager( 'attribute' );
		$search = $manager->createSearch()->setSlice( 0, 0x7fffffff );
		$search->setConditions( $search->compare( '==', 'order.service.attribute.parentid', $ids ) );

		$result = [];
		foreach( $manager->searchItems( $search ) as $item ) {
			$result[$item->getParentId()][$item->getId()] = $item;
		}

		return $result;
	}


	/**
	 * Stores the attribute items included in the order service
	 *
	 * @param \Aimeos\MShop\Order\Item\Service\Iface $item Order service item
	 * @return \Aimeos\MShop\Order\Item\Service\Iface Order service item
	 */
	protected function saveAttributeItems( \Aimeos\MShop\Order\Item\Service\Iface $item )
	{
		$manager = $this->getSubManager( 'attribute' );

		foreach( $item->getAttributeItems() as $attrItem )
		{
print_r( $attrItem );
			if( $attrItem->getType() !== 'session' ) {
				$manager->saveItem( $attrItem->setParentId( $item->getId() ) );
			}
		}

		return $item;
	}
}
