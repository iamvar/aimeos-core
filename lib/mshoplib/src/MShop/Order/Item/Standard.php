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
 * Default implementation of an order invoice item.
 *
 * @package MShop
 * @subpackage Order
 */
class Standard
	extends \Aimeos\MShop\Order\Item\Base
	implements \Aimeos\MShop\Order\Item\Iface
{
	/**
	 * Returns the item type
	 *
	 * @return string Item type, subtypes are separated by slashes
	 */
	public function getResourceType()
	{
		return 'order';
	}


	/**
	 * Returns the ID of the site the item is stored.
	 *
	 * @return string|null Site ID (or null if not available)
	 */
	public function getSiteId()
	{
		return $this->get( 'order.siteid' );
	}


	/**
	 * Returns the code of the site the item is stored.
	 *
	 * @return string Site code (or empty string if not available)
	 */
	public function getSiteCode()
	{
		return $this->get( 'order.sitecode', '' );
	}


	/**
	 * Returns the type of the invoice (repeating, web, phone, etc).
	 *
	 * @return string Invoice type
	 */
	public function getType()
	{
		return (string) $this->get( 'order.type', '' );
	}


	/**
	 * Sets the type of the invoice.
	 *
	 * @param string $type Invoice type
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 */
	public function setType( $type )
	{
		return $this->set( 'order.type', $this->checkCode( $type ) );
	}


	/**
	 * Returns the delivery date of the invoice.
	 *
	 * @return string|null ISO date in yyyy-mm-dd HH:ii:ss format
	 */
	public function getDateDelivery()
	{
		return $this->get( 'order.datedelivery' );
	}


	/**
	 * Sets the delivery date of the invoice.
	 *
	 * @param string|null $date ISO date in yyyy-mm-dd HH:ii:ss format
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 */
	public function setDateDelivery( $date )
	{
		return $this->set( 'order.datedelivery', $this->checkDateFormat( $date ) );
	}


	/**
	 * Returns the purchase date of the invoice.
	 *
	 * @return string|null ISO date in yyyy-mm-dd HH:ii:ss format
	 */
	public function getDatePayment()
	{
		return $this->get( 'order.datepayment' );
	}


	/**
	 * Sets the purchase date of the invoice.
	 *
	 * @param string|null $date ISO date in yyyy-mm-dd HH:ii:ss format
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 */
	public function setDatePayment( $date )
	{
		return $this->set( 'order.datepayment', $this->checkDateFormat( $date ) );
	}


	/**
	 * Returns the delivery status of the invoice.
	 *
	 * @return integer Status code constant from \Aimeos\MShop\Order\Item\Base
	 */
	public function getDeliveryStatus()
	{
		return (int) $this->get( 'order.statusdelivery', \Aimeos\MShop\Order\Item\Base::STAT_UNFINISHED );
	}


	/**
	 * Sets the delivery status of the invoice.
	 *
	 * @param integer $status Status code constant from \Aimeos\MShop\Order\Item\Base
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 */
	public function setDeliveryStatus( $status )
	{
		if( (int) $status !== $this->getDeliveryStatus() && $this->get( 'order.datedelivery' ) == null ) {
			$this->set( 'order.datedelivery', date( 'Y-m-d H:i:s' ) );
		}

		$this->set( '.statusdelivery', $this->get( 'order.statusdelivery' ) );
		return $this->set( 'order.statusdelivery', (int) $status );
	}


	/**
	 * Returns the payment status of the invoice.
	 *
	 * @return integer Payment constant from \Aimeos\MShop\Order\Item\Base
	 */
	public function getPaymentStatus()
	{
		return (int) $this->get( 'order.statuspayment', \Aimeos\MShop\Order\Item\Base::PAY_UNFINISHED );
	}


	/**
	 * Sets the payment status of the invoice.
	 *
	 * @param integer $status Payment constant from \Aimeos\MShop\Order\Item\Base
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 */
	public function setPaymentStatus( $status )
	{
		if( (int) $status !== $this->getPaymentStatus() && $this->get( 'order.datepayment' ) == null ) {
			$this->set( 'order.datepayment', date( 'Y-m-d H:i:s' ) );
		}

		$this->set( '.statuspayment', $this->get( 'order.statuspayment' ) );
		return $this->set( 'order.statuspayment', (int) $status );
	}


	/**
	 * Returns the related invoice ID.
	 *
	 * @return string|null Related invoice ID
	 */
	public function getRelatedId()
	{
		return $this->get( 'order.relatedid' );
	}


	/**
	 * Sets the related invoice ID.
	 *
	 * @param string|null $id Related invoice ID
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 * @throws \Aimeos\MShop\Order\Exception If ID is invalid
	 */
	public function setRelatedId( $id )
	{
		return $this->set( 'order.relatedid', $id );
	}


	/**
	 * Returns the comment field of the order item.
	 *
	 * @return string Comment for the order
	 */
	public function getComment()
	{
		return $this->get( 'order.comment', '' );
	}


	/**
	 * Sets the comment field of the order item
	 *
	 * @param string $comment Comment for the order
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 */
	public function setComment( $comment )
	{
		return $this->set( 'order.comment', (string) $comment );
	}


	/**
	 * Returns the customer ID of the customer who has ordered.
	 *
	 * @return string Unique ID of the customer
	 */
	public function getCustomerId()
	{
		return (string) $this->get( 'order.customerid' );
	}


	/**
	 * Sets the customer ID of the customer who has ordered.
	 *
	 * @param string $customerid Unique ID of the customer
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 */
	public function setCustomerId( $customerid )
	{
		if( (string) $customerid !== $this->getCustomerId() )
		{
			$this->notify( 'setCustomerId.before', $customerid );
			$this->set( 'order.customerid', (string) $customerid );
			$this->notify( 'setCustomerId.after', $customerid );
		}

		return $this;
	}


	/**
	 * Returns the customer reference field of the order item
	 *
	 * @return string Customer reference for the order
	 */
	public function getCustomerReference()
	{
		return (string) $this->get( 'order.customerref' );
	}


	/**
	 * Sets the customer reference field of the order item
	 *
	 * @param string $value Customer reference for the order
	 * @return \Aimeos\MShop\Order\Item\Iface Order item for chaining method calls
	 */
	public function setCustomerReference( $value )
	{
		return $this->set( 'order.customerref', (string) $value );
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

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case 'order.type': $item = $item->setType( $value ); break;
				case 'order.statusdelivery': $item = $item->setDeliveryStatus( $value ); break;
				case 'order.statuspayment': $item = $item->setPaymentStatus( $value ); break;
				case 'order.datepayment': $item = $item->setDatePayment( $value ); break;
				case 'order.datedelivery': $item = $item->setDateDelivery( $value ); break;
				case 'order.relatedid': $item = $item->setRelatedId( $value ); break;
				case 'order.customerid': $item = $item->setCustomerId( $value ); break;
				case 'order.customerref': $item = $item->setCustomerReference( $value ); break;
				case 'order.comment': $item = $item->setComment( $value ); break;
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

		$list['order.type'] = $this->getType();
		$list['order.sitecode'] = $this->getSiteCode();
		$list['order.statusdelivery'] = $this->getDeliveryStatus();
		$list['order.statuspayment'] = $this->getPaymentStatus();
		$list['order.datepayment'] = $this->getDatePayment();
		$list['order.datedelivery'] = $this->getDateDelivery();
		$list['order.relatedid'] = $this->getRelatedId();
		$list['order.customerid'] = $this->getCustomerId();
		$list['order.customerref'] = $this->getCustomerReference();
		$list['order.comment'] = $this->getComment();

		return $list;
	}


	/**
	 * Checks if the given delivery status is a valid constant.
	 *
	 * @param integer $value Delivery status constant defined in \Aimeos\MShop\Order\Item\Base
	 * @throws \Aimeos\MShop\Order\Exception If delivery status is invalid
	 */
	protected function checkDeliveryStatus( $value )
	{
		if( $value < \Aimeos\MShop\Order\Item\Base::STAT_UNFINISHED || $value > \Aimeos\MShop\Order\Item\Base::STAT_RETURNED ) {
			throw new \Aimeos\MShop\Order\Exception( sprintf( 'Order delivery status "%1$s" not within allowed range', $value ) );
		}

		return (int) $value;
	}


	/**
	 * Checks the given payment status is a valid constant.
	 *
	 * @param integer $value Payment status constant defined in \Aimeos\MShop\Order\Item\Base
	 * @throws \Aimeos\MShop\Order\Exception If payment status is invalid
	 */
	protected function checkPaymentStatus( $value )
	{
		if( $value < \Aimeos\MShop\Order\Item\Base::PAY_UNFINISHED || $value > \Aimeos\MShop\Order\Item\Base::PAY_RECEIVED ) {
			throw new \Aimeos\MShop\Order\Exception( sprintf( 'Order payment status "%1$s" not within allowed range', $value ) );
		}

		return (int) $value;
	}
}
