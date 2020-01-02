<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Order
 */


namespace Aimeos\MShop\Order\Item\Coupon;


/**
 * Default implementation for order item coupon.
 *
 * @package MShop
 * @subpackage Order
 */
class Standard
	extends \Aimeos\MShop\Common\Item\Base
	implements \Aimeos\MShop\Order\Item\Coupon\Iface
{
	/**
	 * Initializes the order coupon item.
	 *
	 * @param array $values Associative list of order coupon values
	 */
	public function __construct( array $values = [] )
	{
		parent::__construct( 'order.coupon.', $values );
	}


	/**
	 * Returns the order ID of the order.
	 *
	 * @return string|null Order ID
	 */
	public function getOrderId()
	{
		return $this->get( 'order.coupon.orderid' );
	}


	/**
	 * Sets the Base ID of the order.
	 *
	 * @param string $orderid Order ID.
	 * @return \Aimeos\MShop\Order\Item\Coupon\Iface Order coupon item for chaining method calls
	 */
	public function setOrderId( $orderid )
	{
		return $this->set( 'order.coupon.orderid', (string) $orderid );
	}


	/**
	 * Returns the ID of the ordered product.
	 *
	 * @return string|null ID of the ordered product.
	 */
	public function getProductId()
	{
		return $this->get( 'order.coupon.ordprodid' );
	}


	/**
	 * Sets the ID of the ordered product.
	 *
	 * @param string $productid ID of the ordered product
	 * @return \Aimeos\MShop\Order\Item\Coupon\Iface Order coupon item for chaining method calls
	 */
	public function setProductId( $productid )
	{
		return $this->set( 'order.coupon.ordprodid', (string) $productid );
	}


	/**
	 * Returns the coupon code.
	 *
	 * @return string|null Coupon code.
	 */
	public function getCode()
	{
		return $this->get( 'order.coupon.code' );
	}


	/**
	 * Sets the coupon code.
	 *
	 * @param string $code Coupon code
	 * @return \Aimeos\MShop\Order\Item\Coupon\Iface Order coupon item for chaining method calls
	 */
	public function setCode( $code )
	{
		return $this->set( 'order.coupon.code', $this->checkCode( $code ) );
	}


	/**
	 * Returns the item type
	 *
	 * @return string Item type, subtypes are separated by slashes
	 */
	public function getResourceType()
	{
		return 'order/coupon';
	}


	/*
	 * Sets the item values from the given array and removes that entries from the list
	 *
	 * @param array &$list Associative list of item keys and their values
	 * @param boolean True to set private properties too, false for public only
	 * @return \Aimeos\MShop\Order\Item\Coupon\Iface Order coupon item for chaining method calls
	 */
	public function fromArray( array &$list, $private = false )
	{
		$item = parent::fromArray( $list, $private );

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case 'order.coupon.orderid': !$private ?: $item = $item->setOrderId( $value ); break;
				case 'order.coupon.productid': !$private ?: $item = $item->setProductId( $value ); break;
				case 'order.coupon.code': $item = $item->setCode( $value ); break;
				default: continue 2;
			}

			unset( $list[$key] );
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
		$list = parent::toArray( $private );

		$list['order.coupon.code'] = $this->getCode();

		if( $private === true )
		{
			$list['order.coupon.orderid'] = $this->getOrderId();
			$list['order.coupon.productid'] = $this->getProductId();
		}

		return $list;
	}

}
