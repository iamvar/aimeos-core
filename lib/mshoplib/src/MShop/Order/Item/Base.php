<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Order
 */


namespace Aimeos\MShop\Order\Item;


/**
 * Base order item class with common constants and methods.
 *
 * @package MShop
 * @subpackage Order
 */
abstract class Base
	extends \Aimeos\MShop\Common\Item\Base
	implements \Aimeos\MShop\Order\Item\Iface
{
	use \Aimeos\MW\Observer\Publisher\Traits;


	/**
	 * Repeated order.
	 * The order is created automatically based on an existing order of the
	 * customer.
	 */
	const TYPE_REPEAT = 'repeat';

	/**
	 * Web/internet order.
	 * The order is created manually by the customer using the web shop.
	 */
	const TYPE_WEB = 'web';

	/**
	 * Phone order.
	 * The order is created manually by an operator talking to the customer
	 * over the phone.
	 */
	const TYPE_PHONE = 'phone';


	/**
	 * Unfinished delivery.
	 * This is the default status after creating an order and this status
	 * should be also used as long as technical errors occurs.
	 */
	const STAT_UNFINISHED = -1;

	/**
	 * Delivery was deleted.
	 * The delivery of the order was deleted manually.
	 */
	const STAT_DELETED = 0;

	/**
	 * Delivery is pending.
	 * The order is not yet in the fulfillment process until further actions
	 * are taken.
	 */
	const STAT_PENDING = 1;

	/**
	 * Fulfillment in progress.
	 * The delivery of the order is in the (internal) fulfillment process and
	 * will be ready soon.
	 */
	const STAT_PROGRESS = 2;

	/**
	 * Parcel is dispatched.
	 * The parcel was given to the logistic partner for delivery to the
	 * customer.
	 */
	const STAT_DISPATCHED = 3;

	/**
	 * Parcel was delivered.
	 * The logistic partner delivered the parcel and the customer received it.
	 */
	const STAT_DELIVERED = 4;

	/**
	 * Parcel is lost.
	 * The parcel is lost during delivery by the logistic partner and haven't
	 * reached the customer nor it's returned to the merchant.
	 */
	const STAT_LOST = 5;

	/**
	 * Parcel was refused.
	 * The delivery of the parcel failed because the customer has refused to
	 * accept it or the address was invalid.
	 */
	const STAT_REFUSED = 6;

	/**
	 * Parcel was returned.
	 * The parcel was sent back by the customer.
	 */
	const STAT_RETURNED = 7;


	/**
	 * Unfinished payment.
	 * This is the default status after creating an order and this status
	 * should be also used as long as technical errors occurs.
	 */
	const PAY_UNFINISHED = -1;

	/**
	 * Payment was deleted.
	 * The payment for the order was deleted manually.
	 */
	const PAY_DELETED = 0;

	/**
	 * Payment was canceled.
	 * The customer canceled the payment process.
	 */
	const PAY_CANCELED = 1;

	/**
	 * Payment was refused.
	 * The customer didn't enter valid payment details.
	 */
	const PAY_REFUSED = 2;

	/**
	 * Payment was refund.
	 * The payment was OK but refund and the customer got his money back.
	 */
	const PAY_REFUND = 3;

	/**
	 * Payment is pending.
	 * The payment is not yet done until further actions are taken.
	 */
	const PAY_PENDING = 4;

	/**
	 * Payment is authorized.
	 * The customer authorized the merchant to invoice the amount but the money
	 * is not yet received. This is used for all post-paid orders.
	 */
	const PAY_AUTHORIZED = 5;

	/**
	 * Payment is received.
	 * The merchant received the money from the customer.
	 */
	const PAY_RECEIVED = 6;


	/**
	 * Check and load/store only basic basket content
	 */
	const PARTS_NONE = 0;

	/**
	 * Check and load/store basket with addresses
	 */
	const PARTS_ADDRESS = 1;

	/**
	 * Load/store basket with coupons
	 */
	const PARTS_COUPON = 2;

	/**
	 * Check and load/store basket with products
	 */
	const PARTS_PRODUCT = 4;

	/**
	 * Check and load/store basket with delivery/payment
	 */
	const PARTS_SERVICE = 8;

	/**
	 * Check and load/store basket with all parts.
	 */
	const PARTS_ALL = 15;


	// protected is a workaround for serialize problem
	protected $bdata;
	protected $price;
	protected $locale;
	protected $coupons;
	protected $products;
	protected $services = [];
	protected $addresses = [];
	protected $recalc = false;


	/**
	 * Initializes the basket object
	 *
	 * @param \Aimeos\MShop\Price\Item\Iface $price Default price of the basket (usually 0.00)
	 * @param \Aimeos\MShop\Locale\Item\Iface $locale Locale item containing the site, language and currency
	 * @param array $values Associative list of key/value pairs containing, e.g. the order or user ID
	 * @param array $products List of ordered products implementing \Aimeos\MShop\Order\Item\Product\Iface
	 * @param array $addresses List of order addresses implementing \Aimeos\MShop\Order\Item\Address\Iface
	 * @param array $services List of order services implementing \Aimeos\MShop\Order\Item\Service\Iface
	 * @param array $coupons Associative list of coupon codes as keys and ordered products implementing \Aimeos\MShop\Order\Item\Product\Iface as values
	 */
	public function __construct( \Aimeos\MShop\Price\Item\Iface $price, \Aimeos\MShop\Locale\Item\Iface $locale,
		array $values = [], array $products = [], array $addresses = [],
		array $services = [], array $coupons = [] )
	{
		parent::__construct( 'order.', $values );

		\Aimeos\MW\Common\Base::checkClassList( \Aimeos\MShop\Order\Item\Address\Iface::class, $addresses );
		\Aimeos\MW\Common\Base::checkClassList( \Aimeos\MShop\Order\Item\Product\Iface::class, $products );
		\Aimeos\MW\Common\Base::checkClassList( \Aimeos\MShop\Order\Item\Service\Iface::class, $services );

		foreach( $coupons as $couponProducts ) {
			\Aimeos\MW\Common\Base::checkClassList( \Aimeos\MShop\Order\Item\Product\Iface::class, $couponProducts );
		}

		$this->price = $price;
		$this->bdata = $values;
		$this->locale = $locale;
		$this->coupons = $coupons;
		$this->products = $products;

		foreach( $addresses as $address ) {
			$this->addresses[$address->getType()][$address->getPosition()] = $address;
		}

		foreach( $services as $service ) {
			$this->services[$service->getType()][$service->getPosition()] = $service;
		}
	}


	/**
	 * Clones internal objects of the order item.
	 */
	public function __clone()
	{
		$this->locale = clone $this->locale;
		$this->price = clone $this->price;
	}


	/**
	 * Prepares the object for serialization.
	 *
	 * @return array List of properties that should be serialized
	 */
	public function __sleep()
	{
		/*
		 * Workaround because database connections can't be serialized
		 * Listeners will be reattached on wakeup by the order manager
		 */
		$this->off();

		return array_keys( get_object_vars( $this ) );
	}


	/**
	 * Tests if all necessary items are available to create the order.
	 *
	 * @param integer $what Test for the specific type of completeness
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 * @throws \Aimeos\MShop\Order\Exception if there are no products in the basket
	 */
	public function check( $what = self::PARTS_ALL )
	{
		$what = (int) $what;

		if( $what < self::PARTS_NONE || $what > self::PARTS_ALL ) {
			throw new \Aimeos\MShop\Order\Exception( sprintf( 'Flags not within allowed range' ) );
		}

		$this->notify( 'check.before', $what );

		if( ( $what & self::PARTS_PRODUCT ) && empty( $this->getProducts() ) ) {
			throw new \Aimeos\MShop\Order\Exception( sprintf( 'Basket empty' ) );
		}

		$this->notify( 'check.after', $what );

		return $this;
	}


	/**
	 * Notifies listeners before the basket becomes an order.
	 *
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 */
	public function finish()
	{
		$this->notify( 'setOrder.before' );
		return $this;
	}


	/**
	 * Returns a price item with amounts calculated for the products, costs, etc.
	 *
	 * @return \Aimeos\MShop\Price\Item\Iface Price item with price, costs and rebate the customer has to pay
	 */
	public function getPrice()
	{
		if( $this->recalc === true )
		{
			$price = $this->price->clear();

			foreach( $this->getServices() as $list )
			{
				foreach( $list as $service ) {
					$price = $price->addItem( $service->getPrice() );
				}
			}

			foreach( $this->getProducts() as $product ) {
				$price = $price->addItem( $product->getPrice(), $product->getQuantity() );
			}

			$this->price = $price;
			$this->recalc = false;
		}

		return $this->price;
	}


	/**
	 * Adds the address of the given type to the basket
	 *
	 * @param \Aimeos\MShop\Order\Item\Address\Iface $address Order address item for the given type
	 * @param string $type Address type, usually "billing" or "delivery"
	 * @param integer|null $position Position of the address in the list
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function addAddress( \Aimeos\MShop\Order\Item\Address\Iface $address, $type, $position = null )
	{
		$address = $this->notify( 'addAddress.before', $address );

		$address = clone $address;
		$address = $address->setType( $type );

		if( $position !== null ) {
			$this->addresses[$type][$position] = $address;
		} else {
			$this->addresses[$type][] = $address;
		}

		$this->setModified();

		$this->notify( 'addAddress.after', $address );

		return $this;
	}


	/**
	 * Deletes an order address from the basket
	 *
	 * @param string $type Address type defined in \Aimeos\MShop\Order\Item\Address\Base
	 * @param integer|null $position Position of the address in the list
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function deleteAddress( $type, $position = null )
	{
		if( $position === null && isset( $this->addresses[$type] ) || isset( $this->addresses[$type][$position] ) )
		{
			$old = ( isset( $this->addresses[$type][$position] ) ? $this->addresses[$type][$position] : $this->addresses[$type] );
			$old = $this->notify( 'deleteAddress.before', $old );

			if( $position !== null ) {
				unset( $this->addresses[$type][$position] );
			} else {
				unset( $this->addresses[$type] );
			}

			$this->setModified();

			$this->notify( 'deleteAddress.after', $old );
		}

		return $this;
	}


	/**
	 * Returns the order address depending on the given type
	 *
	 * @param string $type Address type, usually "billing" or "delivery"
	 * @param integer|null $position Address position in list of addresses
	 * @return \Aimeos\MShop\Order\Item\Address\Iface[]|\Aimeos\MShop\Order\Item\Address\Iface Order address item or list of
	 */
	public function getAddress( $type, $position = null )
	{
		if( $position !== null )
		{
			if( isset( $this->addresses[$type][$position] ) ) {
				return $this->addresses[$type][$position];
			}

			throw new \Aimeos\MShop\Order\Exception( sprintf( 'Address not available' ) );
		}

		return ( isset( $this->addresses[$type] ) ? $this->addresses[$type] : [] );
	}


	/**
	 * Returns all addresses that are part of the basket
	 *
	 * @return array Associative list of address items implementing
	 *  \Aimeos\MShop\Order\Item\Address\Iface with "billing" or "delivery" as key
	 */
	public function getAddresses()
	{
		return $this->addresses;
	}


	/**
	 * Replaces all addresses in the current basket with the new ones
	 *
	 * @param array $map Associative list of order addresses as returned by getAddresses()
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function setAddresses( array $map )
	{
		$map = $this->notify( 'setAddresses.before', $map );

		foreach( $map as $type => $items ) {
			$this->checkAddresses( $items, $type );
		}

		$old = $this->addresses;
		$this->addresses = $map;
		$this->setModified();

		$this->notify( 'setAddresses.after', $old );

		return $this;
	}


	/**
	 * Adds a coupon code and the given product item to the basket
	 *
	 * @param string $code Coupon code
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function addCoupon( $code )
	{
		if( !isset( $this->coupons[$code] ) )
		{
			$code = $this->notify( 'addCoupon.before', $code );

			$this->coupons[$code] = [];
			$this->setModified();
			$this->recalc = true;

			$this->notify( 'addCoupon.after', $code );
		}

		return $this;
	}


	/**
	 * Removes a coupon and the related product items from the basket
	 *
	 * @param string $code Coupon code
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function deleteCoupon( $code )
	{
		if( isset( $this->coupons[$code] ) )
		{
			$old = [$code => $this->coupons[$code]];
			$old = $this->notify( 'deleteCoupon.before', $old );

			foreach( $this->coupons[$code] as $product )
			{
				if( ( $key = array_search( $product, $this->products, true ) ) !== false ) {
					unset( $this->products[$key] );
				}
			}

			unset( $this->coupons[$code] );
			$this->setModified();
			$this->recalc = true;

			$this->notify( 'deleteCoupon.after', $old );
		}

		return $this;
	}


	/**
	 * Returns the available coupon codes and the lists of affected product items
	 *
	 * @return array Associative array of codes and lists of product items
	 *  implementing \Aimeos\MShop\Order\Product\Iface
	 */
	public function getCoupons()
	{
		return $this->coupons;
	}


	/**
	 * Sets a coupon code and the given product items in the basket.
	 *
	 * @param string $code Coupon code
	 * @param \Aimeos\MShop\Order\Item\Product\Iface[] $products List of coupon products
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function setCoupon( $code, array $products = [] )
	{
		$new = $this->notify( 'setCoupon.before', [$code => $products] );

		$products = $this->checkProducts( current( $new ) );
		$code = key( $new );

		if( isset( $this->coupons[$code] ) )
		{
			foreach( $this->coupons[$code] as $product )
			{
				if( ( $key = array_search( $product, $this->products, true ) ) !== false ) {
					unset( $this->products[$key] );
				}
			}
		}

		foreach( $products as $product ) {
			$this->products[] = $product;
		}

		$old = isset( $this->coupons[$code] ) ? [$code => $this->coupons[$code]] : [];
		$this->coupons[$code] = $products;
		$this->setModified();
		$this->recalc = true;

		$this->notify( 'setCoupon.after', $old );

		return $this;
	}


	/**
	 * Replaces all coupons in the current basket with the new ones
	 *
	 * @param array $map Associative list of order coupons as returned by getCoupons()
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function setCoupons( array $map )
	{
		$map = $this->notify( 'setCoupons.before', $map );

		foreach( $map as $code => $products ) {
			$map[$code] = $this->checkProducts( $products );
		}

		foreach( $this->coupons as $code => $products )
		{
			foreach( $products as $product )
			{
				if( ( $key = array_search( $product, $this->products, true ) ) !== false ) {
					unset( $this->products[$key] );
				}
			}
		}

		foreach( $map as $code => $products )
		{
			foreach( $products as $product ) {
				$this->products[] = $product;
			}
		}

		$old = $this->coupons;
		$this->coupons = $map;
		$this->setModified();
		$this->recalc = true;

		$this->notify( 'setCoupons.after', $old );

		return $this;
	}


	/**
	 * Returns the locales for the basic order item.
	 *
	 * @return \Aimeos\MShop\Locale\Item\Iface Object containing information
	 *  about site, language, country and currency
	 */
	public function getLocale()
	{
		return $this->locale;
	}


	/**
	 * Sets the locales for the basic order item.
	 *
	 * @param \Aimeos\MShop\Locale\Item\Iface $locale Object containing information
	 *  about site, language, country and currency
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 */
	public function setLocale( \Aimeos\MShop\Locale\Item\Iface $locale )
	{
		$this->notify( 'setLocale.before', $locale );

		$this->locale = clone $locale;
		$this->modified = true;

		$this->notify( 'setLocale.after', $locale );

		return $this;
	}


	/**
	 * Adds an order product item to the basket
	 * If a similar item is found, only the quantity is increased.
	 *
	 * @param \Aimeos\MShop\Order\Item\Product\Iface $item Order product item to be added
	 * @param integer|null $position position of the new order product item
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function addProduct( \Aimeos\MShop\Order\Item\Product\Iface $item, $position = null )
	{
		$item = $this->notify( 'addProduct.before', $item );

		$this->checkProducts( [$item] );

		if( $position !== null ) {
			$this->products[$position] = $item;
		} elseif( ( $pos = $this->getSameProduct( $item, $this->products ) ) !== false ) {
			$this->products[$pos]->setQuantity( $this->products[$pos]->getQuantity() + $item->getQuantity() );
		} else {
			$this->products[] = $item;
		}

		ksort( $this->products );
		$this->setModified();
		$this->recalc = true;

		$this->notify( 'addProduct.after', $item );

		return $this;
	}


	/**
	 * Deletes an order product item from the basket
	 *
	 * @param integer $position Position of the order product item
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function deleteProduct( $position )
	{
		if( isset( $this->products[$position] ) )
		{
			$old = $this->products[$position];
			$old = $this->notify( 'deleteProduct.before', $old );

			unset( $this->products[$position] );
			$this->setModified();
			$this->recalc = true;

			$this->notify( 'deleteProduct.after', $old );
		}

		return $this;
	}


	/**
	 * Returns the product item of an basket specified by its key
	 *
	 * @param integer $key Key returned by getProducts() identifying the requested product
	 * @return \Aimeos\MShop\Order\Item\Product\Iface Product item of an order
	 */
	public function getProduct( $key )
	{
		if( !isset( $this->products[$key] ) ) {
			throw new \Aimeos\MShop\Order\Exception( sprintf( 'Product not available' ) );
		}

		return $this->products[$key];
	}


	/**
	 * Returns the product items that are or should be part of a basket
	 *
	 * @return \Aimeos\MShop\Order\Item\Product\Iface[] List of order product items
	 */
	public function getProducts()
	{
		return $this->products;
	}


	/**
	 * Replaces all products in the current basket with the new ones
	 *
	 * @param array $map Associative list of ordered products as returned by getProducts()
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function setProducts( array $map )
	{
		$map = $this->notify( 'setProducts.before', $map );

		$this->checkProducts( $map );

		$old = $this->products;
		$this->products = $map;
		$this->setModified();
		$this->recalc = true;

		$this->notify( 'setProducts.after', $old );

		return $this;
	}


	/**
	 * Adds an order service to the basket
	 *
	 * @param \Aimeos\MShop\Order\Item\Service\Iface $service Order service item for the given domain
	 * @param string $type Service type constant from \Aimeos\MShop\Order\Item\Service\Base
	 * @param integer|null $position Position of the service in the list to overwrite
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function addService( \Aimeos\MShop\Order\Item\Service\Iface $service, $type, $position = null )
	{
		$service = $this->notify( 'addService.before', $service );

		$this->checkPrice( $service->getPrice() );

		$service = clone $service;
		$service = $service->setType( $type );

		if( $position !== null ) {
			$this->services[$type][$position] = $service;
		} else {
			$this->services[$type][] = $service;
		}

		$this->setModified();
		$this->recalc = true;

		$this->notify( 'addService.after', $service );

		return $this;
	}


	/**
	 * Deletes an order service from the basket
	 *
	 * @param string $type Service type constant from \Aimeos\MShop\Order\Item\Service\Base
	 * @param integer|null $position Position of the service in the list to delete
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function deleteService( $type, $position = null )
	{
		if( $position === null && isset( $this->services[$type] ) || isset( $this->services[$type][$position] ) )
		{
			$old = ( isset( $this->services[$type][$position] ) ? $this->services[$type][$position] : $this->services[$type] );
			$old = $this->notify( 'deleteService.before', $old );

			if( $position !== null ) {
				unset( $this->services[$type][$position] );
			} else {
				unset( $this->services[$type] );
			}

			$this->setModified();
			$this->recalc = true;

			$this->notify( 'deleteService.after', $old );
		}

		return $this;
	}


	/**
	 * Returns the order services depending on the given type
	 *
	 * @param string $type Service type constant from \Aimeos\MShop\Order\Item\Service\Base
	 * @param integer|null $position Position of the service in the list to retrieve
	 * @return \Aimeos\MShop\Order\Item\Service\Iface[]|\Aimeos\MShop\Order\Item\Service\Iface
	 * 	Order service item or list of items for the requested type
	 * @throws \Aimeos\MShop\Order\Exception If no service for the given type and position is found
	 */
	public function getService( $type, $position = null )
	{
		if( $position !== null )
		{
			if( isset( $this->services[$type][$position] ) ) {
				return $this->services[$type][$position];
			}

			throw new \Aimeos\MShop\Order\Exception( sprintf( 'Service not available' ) );
		}

		return ( isset( $this->services[$type] ) ? $this->services[$type] : [] );
	}


	/**
	 * Returns all services that are part of the basket
	 *
	 * @return array Associative list of service types ("delivery" or "payment") as keys and list of
	 *	service items implementing \Aimeos\MShop\Order\Service\Iface as values
	 */
	public function getServices()
	{
		return $this->services;
	}


	/**
	 * Replaces all services in the current basket with the new ones
	 *
	 * @param array $map Associative list of order services as returned by getServices()
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for method chaining
	 */
	public function setServices( array $map )
	{
		$map = $this->notify( 'setServices.before', $map );

		foreach( $map as $type => $services ) {
			$map[$type] = $this->checkServices( $services, $type );
		}

		$old = $this->services;
		$this->services = $map;
		$this->setModified();
		$this->recalc = true;

		$this->notify( 'setServices.after', $old );

		return $this;
	}


	/*
	 * Sets the item values from the given array and removes that entries from the list
	 *
	 * @param array &$list Associative list of item keys and their values
	 * @param boolean True to set private properties too, false for public only
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 */
	public function fromArray( array &$list, $private = false )
	{
		$item = parent::fromArray( $list, $private );

		if( isset( $list['order.languageid'] ) )
		{
			$item->setLocale( $this->getLocale()->setLanguageId( $list['order.languageid'] ) );
			unset( $list['order.languageid'] );
		}

		return $item;
	}


	/**
	 * Returns the item values as array.
	 *
	 * @param boolean True to return private properties, false for public only
	 * @return array Associative list of item properties and their values
	 */
	public function toArray( $private = false )
	{
		$price = $this->getPrice();
		$list = parent::toArray( $private );

		$list['order.languageid'] = $this->getLocale()->getLanguageId();
		$list['order.currencyid'] = $price->getCurrencyId();
		$list['order.price'] = $price->getValue();
		$list['order.costs'] = $price->getCosts();
		$list['order.rebate'] = $price->getRebate();
		$list['order.tax'] = $price->getTaxValue();
		$list['order.taxflag'] = $price->getTaxFlag();

		return $list;
	}


	/**
	 * Checks if all order addresses are valid
	 *
	 * @param \Aimeos\MShop\Order\Item\Address\Iface[] $items Order address items
	 * @param string $type Address type constant from \Aimeos\MShop\Order\Item\Address\Base
	 * @return \Aimeos\MShop\Order\Item\Address\Iface[] List of checked items
	 * @throws \Aimeos\MShop\Exception If one of the order addresses is invalid
	 */
	protected function checkAddresses( array $items, $type )
	{
		foreach( $items as $key => $item )
		{
			\Aimeos\MW\Common\Base::checkClass( \Aimeos\MShop\Order\Item\Address\Iface::class, $item );
			$items[$key] = $item->setType( $type )->setId( null ); // enforce that the type and saving as new item
		}

		return $items;
	}


	/**
	 * Checks if the price uses the same currency as the price in the basket.
	 *
	 * @param \Aimeos\MShop\Price\Item\Iface $item Price item
	 */
	protected function checkPrice( \Aimeos\MShop\Price\Item\Iface $item )
	{
		$price = clone $this->price;
		$price->addItem( $item );
	}


	/**
	 * Checks if all order products are valid
	 *
	 * @param \Aimeos\MShop\Order\Item\Product\Iface[] $items Order product items
	 * @return \Aimeos\MShop\Order\Item\Product\Iface[] List of checked items
	 * @throws \Aimeos\MShop\Exception If one of the order products is invalid
	 */
	protected function checkProducts( array $items )
	{
		foreach( $items as $key => $item )
		{
			\Aimeos\MW\Common\Base::checkClass( \Aimeos\MShop\Order\Item\Product\Iface::class, $item );

			if( $item->getProductCode() === '' ) {
				throw new \Aimeos\MShop\Order\Exception( sprintf( 'Product does not contain the SKU code' ) );
			}

			$this->checkPrice( $item->getPrice() );
			$items[$key] = $item->setId( null ); // enforce saving as new item
		}

		return $items;
	}


	/**
	 * Checks if all order services are valid
	 *
	 * @param \Aimeos\MShop\Order\Item\Service\Iface[] $items Order service items
	 * @param string $type Service type constant from \Aimeos\MShop\Order\Item\Service\Base
	 * @return \Aimeos\MShop\Order\Item\Service\Iface[] List of checked items
	 * @throws \Aimeos\MShop\Exception If one of the order services is invalid
	 */
	protected function checkServices( array $items, $type )
	{
		foreach( $items as $key => $item )
		{
			\Aimeos\MW\Common\Base::checkClass( \Aimeos\MShop\Order\Item\Service\Iface::class, $item );

			$this->checkPrice( $item->getPrice() );
			$items[$key] = $item->setType( $type )->setId( null ); // enforce the type and saving as new item
		}

		return $items;
	}


	/**
	 * Tests if the given product is similar to an existing one.
	 * Similarity is described by the equality of properties so the quantity of
	 * the existing product can be updated.
	 *
	 * @param \Aimeos\MShop\Order\Item\Product\Iface $item Order product item
	 * @param array $products List of order product items to check against
	 * @return integer|false Positon of the same product in the product list of false if product is unique
	 * @throws \Aimeos\MShop\Order\Exception If no similar item was found
	 */
	protected function getSameProduct( \Aimeos\MShop\Order\Item\Product\Iface $item, array $products )
	{
		$attributeMap = [];
		$attributeCount = 0;

		foreach( $item->getAttributeItems() as $attributeItem )
		{
			$attributeMap[$attributeItem->getCode()][$attributeItem->getValue()] = $attributeItem;
			$attributeCount++;
		}

		foreach( $products as $position => $product )
		{
			if( $product->compare( $item ) === false ) {
				continue;
			}

			$prodAttributes = $product->getAttributeItems();

			if( count( $prodAttributes ) !== $attributeCount ) {
				continue;
			}

			foreach( $prodAttributes as $attribute )
			{
				if( isset( $attributeMap[$attribute->getCode()][$attribute->getValue()] ) === false
					|| $attributeMap[$attribute->getCode()][$attribute->getValue()]->getQuantity() != $attribute->getQuantity()
				) {
					continue 2; // jump to outer loop
				}
			}

			return $position;
		}

		return false;
	}
}
