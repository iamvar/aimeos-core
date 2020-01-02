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
 * Interface for coupon items.
 *
 * @package MShop
 * @subpackage Order
 */
interface Iface extends \Aimeos\MShop\Common\Item\Iface
{
	/**
	 * Returns the order ID of the order.
	 *
	 * @return string Order ID.
	 */
	public function getOrderId();

	/**
	 * Sets the order ID of the order.
	 *
	 * @param string $orderid Order ID.
	 * @return \Aimeos\MShop\Order\Item\Coupon\Iface Order coupon item for chaining method calls
	 */
	public function setOrderId( $orderid );

	/**
	 *	Returns the product id of the ordered product.
	 *
	 *  @return string Product ID of the ordered product
	 */
	public function getProductId();


	/**
	 * 	Sets the product ID of the ordered product
	 *
	 *	@param string $productid The product ID of the ordered product
	 * @return \Aimeos\MShop\Order\Item\Coupon\Iface Order coupon item for chaining method calls
	 */
	public function setProductId( $productid );

	/**
	 * Returns the coupon code the customer has selected.
	 *
	 * @return string Returns the coupon code the customer has selected.
	 */
	public function getCode();

	/**
	 * Sets the code of a coupon the customer has selected.
	 *
	 * @param string $code The code of a coupon the customer has selected.
	 * @return \Aimeos\MShop\Order\Item\Coupon\Iface Order coupon item for chaining method calls
	 */
	public function setCode( $code );
}
