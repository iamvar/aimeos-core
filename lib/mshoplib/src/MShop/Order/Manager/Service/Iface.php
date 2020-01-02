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
 * Interface for order service managers.
 *
 * @package MShop
 * @subpackage Order
 */
interface Iface
	extends \Aimeos\MShop\Common\Manager\Iface
{
	/**
	 * Creates a new service attribute item object
	 *
	 * @param array $values Values the item should be initialized with
	 * @return \Aimeos\MShop\Order\Item\Product\Attribute\Iface New service attribute item object
	 */
	public function createAttributeItem( array $values = [] );

	/**
	 * Adds or updates an order service item to the storage.
	 *
	 * @param \Aimeos\MShop\Order\Item\Service\Iface $item Order service object
	 * @param boolean $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Order\Item\Service\Iface $item Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Order\Item\Service\Iface $item, $fetch = true );
}
