<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2015-2018
 */

return [
	'order' => [[
		'order.type' => 'web', 'order.statuspayment' => 6, 'order.statusdelivery' => 4,
		'order.datepayment' => '2008-02-15 12:34:56', 'order.datedelivery' => null, 'order.relatedid' => null,
		'order.customerid' => 'UTC001', 'order.sitecode' => 'unittest', 'order.languageid' => 'de', 'order.currencyid' => 'EUR',
		'order.price' => '53.50', 'order.costs' => '1.50', 'order.rebate' => '14.50', 'order.taxflag' => 1,
		'order.customerref' => 'ABC-1234', 'order.comment' => 'This is a comment if an order. It can be added by the user.',
		'address' => [[
			'order.address.addressid' => 101, 'order.address.type' => 'delivery', 'order.address.company' => 'Example company',
			'order.address.vatid' => 'DE999999999', 'order.address.salutation' => 'mr', 'order.address.title' => 'Dr.',
			'order.address.firstname' => 'Our', 'order.address.lastname' => 'Unittest',
			'order.address.address1' => 'Pickhuben', 'order.address.address2' => '2-4', 'order.address.address3' => '',
			'order.address.postal' => '20457', 'order.address.city' => 'Hamburg', 'order.address.state' => 'Hamburg',
			'order.address.countryid' => 'de', 'order.address.languageid' => 'de', 'order.address.telephone' => '055544332211',
			'order.address.email' => 'test@example.com', 'order.address.telefax' => '055544332212',
			'order.address.website' => 'www.example.com', 'order.address.longitude' => '10.0', 'order.address.latitude' => '50.0',
			'order.address.flag' => null
		], [
			'order.address.addressid' => 103, 'order.address.type' => 'payment', 'order.address.company' => null,
			'order.address.vatid' => null, 'order.address.salutation' => 'mr', 'order.address.title' => '',
			'order.address.firstname' => 'Our', 'order.address.lastname' => 'Unittest',
			'order.address.address1' => 'Durchschnitt', 'order.address.address2' => '1', 'order.address.address3' => '',
			'order.address.postal' => '20146', 'order.address.city' => 'Hamburg', 'order.address.state' => 'Hamburg',
			'order.address.countryid' => 'de', 'order.address.languageid' => 'de', 'order.address.telephone' => '055544332211',
			'order.address.email' => 'test@example.com', 'order.address.telefax' => '055544332213',
			'order.address.website' => 'aimeos.org', 'order.address.longitude' => '11.0', 'order.address.latitude' => '52.0',
			'order.address.flag' => null
		]],
		'product' => [[
			'order.product.type' => 'default', 'order.product.prodcode' => 'CNE', 'order.product.suppliercode' => 'unitsupplier',
			'order.product.stocktype' => 'unit_type1', 'order.product.name' => 'Cafe Noire Expresso',
			'order.product.mediaurl' => 'somewhere/thump1.jpg', 'order.product.quantity' => 9, 'order.product.currencyid' => 'EUR',
			'order.product.price' => '4.50', 'order.product.costs' => '0.00', 'order.product.rebate' => '0.00',
			'order.product.taxrates' => ['' => '0.00'], 'order.product.taxflag' => 1, 'order.product.flags' => 0,
			'order.product.position' => 1, 'order.product.status' => 1, 'order.product.timeframe' => '4-5d',
			'attribute' => [[
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'width',
				'order.product.attribute.value' => 33, 'order.product.name' => '33',
				'order.product.attribute.quantity' => 1
			], [
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'length',
				'order.product.attribute.value' => 36, 'order.product.name' => '36',
				'order.product.attribute.quantity' => 1
			], [
				'order.product.attribute.type' => 'config', 'order.product.attribute.code' => 'interval',
				'order.product.attribute.value' => 'P0Y1M0W0D', 'order.product.name' => 'P0Y1M0W0D',
				'order.product.attribute.quantity' => 1
			]],
			'subscription' => [
				'order.datenext' => '2000-01-01', 'order.dateend' => '2010-01-01', 'order.interval' => 'P0Y1M0W0D',
				'order.period' => 5, 'order.reason' => 1, 'order.status' => 1
			],
		], [
			'order.product.type' => 'default', 'order.product.prodcode' => 'CNC', 'order.product.suppliercode' => 'unitsupplier',
			'order.product.stocktype' => 'unit_type2', 'order.product.name' => 'Cafe Noire Cappuccino',
			'order.product.mediaurl' => 'somewhere/thump2.jpg', 'order.product.quantity' => 3, 'order.product.currencyid' => 'EUR',
			'order.product.price' => '6.00', 'order.product.costs' => '0.50', 'order.product.rebate' => '0.00',
			'order.product.taxrates' => ['' => '0.00'], 'order.product.taxflag' => 1, 'order.product.flags' => 0,
			'order.product.position' => 2, 'order.product.status' => 1,
			'attribute' => [[
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'size',
				'order.product.attribute.value' => 's', 'order.product.name' => 'small',
				'order.product.attribute.quantity' => 1,
			], [
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'color',
				'order.product.attribute.value' => 'blue', 'order.product.name' => 'blau',
				'order.product.attribute.quantity' => 1,
			], [
				'order.product.attribute.type' => 'config', 'order.product.attribute.code' => 'interval',
				'order.product.attribute.value' => 'P1Y0M0W0D', 'order.product.name' => 'P1Y0M0W0D',
				'order.product.attribute.quantity' => 1,
			]],
			'subscription' => [
				'order.datenext' => '2000-01-01', 'order.dateend' => '2020-01-01', 'order.interval' => 'P1Y0M0W0D',
				'order.period' => 20, 'order.reason' => null, 'order.status' => 0
			],
		], [
			'order.product.type' => 'default', 'order.product.prodcode' => 'U:MD', 'order.product.suppliercode' => 'unitsupplier',
			'order.product.stocktype' => 'unit_type3', 'order.product.name' => 'Unittest: Monetary rebate',
			'order.product.mediaurl' => 'somewhere/thump3.jpg', 'order.product.quantity' => 1, 'order.product.currencyid' => 'EUR',
			'order.product.price' => '-5.00', 'order.product.costs' => '0.00', 'order.product.rebate' => '5.00',
			'order.product.taxrates' => ['' => '0.00'], 'order.product.taxflag' => 1, 'order.product.flags' => 1,
			'order.product.position' => 3, 'order.product.status' => 1,
			'attribute' => [[
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'size',
				'order.product.attribute.value' => 's', 'order.product.name' => 'small',
				'order.product.attribute.quantity' => 1,
			], [
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'color',
				'order.product.attribute.value' => 'white', 'order.product.name' => 'weiss',
				'order.product.attribute.quantity' => 1,
			]],
			'coupon' => [[
				'order.coupon.code' => '5678'
			]]
		], [
			'order.product.type' => 'default', 'order.product.prodcode' => 'ABCD', 'order.product.suppliercode' => 'unitsupplier',
			'order.product.stocktype' => 'unit_type1', 'order.product.name' => '16 discs',
			'order.product.mediaurl' => 'somewhere/thump4.jpg', 'order.product.quantity' => 1, 'order.product.currencyid' => 'EUR',
			'order.product.price' => '0.00', 'order.product.costs' => '0.00', 'order.product.rebate' => '4.50',
			'order.product.taxrates' => ['' => '0.00'], 'order.product.taxflag' => 1, 'order.product.flags' => 1,
			'order.product.position' => 4, 'order.product.status' => 1,
			'attribute' => [[
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'width',
				'order.product.attribute.value' => 32, 'order.product.name' => '32',
				'order.product.attribute.quantity' => 1,
			], [
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'length',
				'order.product.attribute.value' => 30, 'order.product.name' => '30',
				'order.product.attribute.quantity' => 1,
			]],
			'coupon' => [[
				'order.coupon.code' => 'OPQR'
			]]
		]],
		'service' => [[
			'order.service.serviceid' => 'unitpaymentcode', 'order.service.type' => 'payment', 'order.service.code' => 'OGONE',
			'order.service.name' => 'ogone', 'order.service.currencyid' => 'EUR', 'order.service.price' => '0.00',
			'order.service.costs' => '0.00', 'order.service.rebate' => '0.00', 'order.service.taxrates' => ['' => '0.00'],
			'order.service.mediaurl' => 'somewhere/thump1.jpg',
			'attribute' => [[
				'order.service.attribute.type' => 'payment', 'order.service.attribute.name' => 'account owner',
				'order.service.attribute.code' => 'ACOWNER', 'order.service.attribute.value' => 'test user',
				'order.service.attribute.quantity' => 1,
			], [
				'order.service.attribute.type' => 'payment', 'order.service.attribute.name' => 'account number',
				'order.service.attribute.code' => 'ACSTRING', 'order.service.attribute.value' => 9876543,
				'order.service.attribute.quantity' => 1,
			], [
				'order.service.attribute.type' => 'payment', 'order.service.attribute.name' => 'payment method',
				'order.service.attribute.code' => 'NAME', 'order.service.attribute.value' => 'CreditCard',
				'order.service.attribute.quantity' => 1,
			], [
				'order.service.attribute.type' => 'payment', 'order.service.attribute.name' => 'reference id',
				'order.service.attribute.code' => 'REFID', 'order.service.attribute.value' => 12345678,
				'order.service.attribute.quantity' => 1,
			], [
				'order.service.attribute.type' => 'payment', 'order.service.attribute.name' => 'transaction date',
				'order.service.attribute.code' => 'TXDATE', 'order.service.attribute.value' => '2009-08-18',
				'order.service.attribute.quantity' => 1,
			], [
				'order.service.attribute.type' => 'payment', 'order.service.attribute.name' => 'transaction account',
				'order.service.attribute.code' => 'X-ACCOUNT', 'order.service.attribute.value' => 'Kraft02',
				'order.service.attribute.quantity' => 1,
			], [
				'order.service.attribute.type' => 'payment', 'order.service.attribute.name' => 'transaction status',
				'order.service.attribute.code' => 'X-STATUS', 'order.service.attribute.value' => 9,
				'order.service.attribute.quantity' => 1,
			], [
				'order.service.attribute.type' => 'payment', 'order.service.attribute.name' => 'ogone alias name',
				'order.service.attribute.code' => 'Ogone-alias-name', 'order.service.attribute.value' => 'aliasName',
				'order.service.attribute.quantity' => 1,
			], [
				'order.service.attribute.type' => 'payment', 'order.service.attribute.name' => 'ogone alias value',
				'order.service.attribute.code' => 'Ogone-alias-value', 'order.service.attribute.value' => 'aliasValue',
				'order.service.attribute.quantity' => 1,
			]]
		], [
			'order.service.serviceid' => 'unitcode', 'order.service.type' => 'delivery', 'order.service.code' => 73,
			'order.service.name' => 'solucia', 'order.service.currencyid' => 'EUR', 'order.service.price' => '0.00',
			'order.service.costs' => '5.00', 'order.service.rebate' => '0.00', 'order.service.taxrates' => ['' => '0.00'],
			'order.service.mediaurl' => 'somewhere/thump1.jpg',
		]],
		'status' => [[
			'order.status.type' => 'typestatus', 'order.status.value' => 'shipped'
		]]
	], [
		'order.type' => 'phone', 'order.statuspayment' => 6, 'order.statusdelivery' => 4,
		'order.datepayment' => '2009-09-17 16:14:32', 'order.datedelivery' => null, 'order.relatedid' => null,
		'order.customerid' => 'UTC001', 'order.sitecode' => 'unittest', 'order.languageid' => 'de', 'order.currencyid' => 'EUR',
		'order.price' => '672.00', 'order.costs' => '32.00', 'order.rebate' => '5.00', 'order.tax' => '112.4034',
		'order.taxflag' => 1, 'order.customerref' => 'ABC-9876', 'order.comment' => 'This is another comment.',
		'address' => [[
			'order.address.addressid' => 102, 'order.address.type' => 'delivery', 'order.address.company' => 'Example company',
			'order.address.vatid' => 'DE999999999', 'order.address.salutation' => 'mrs', 'order.address.title' => 'Dr.',
			'order.address.firstname' => 'Maria', 'order.address.lastname' => 'Mustertest',
			'order.address.address1' => 'Pickhuben', 'order.address.address2' => '2', 'order.address.address3' => '',
			'order.address.postal' => '20457', 'order.address.city' => 'Hamburg', 'order.address.state' => 'Hamburg',
			'order.address.countryid' => 'de', 'order.address.languageid' => 'de', 'order.address.telephone' => '055544332211',
			'order.address.email' => 'test@example.com', 'order.address.telefax' => '055544332212',
			'order.address.website' => 'www.example.com', 'order.address.longitude' => '10.5','order.address.latitude' => '51.0',
			'order.address.flag' => null
		], [
			'order.address.addressid' => 104, 'order.address.type' => 'payment', 'order.address.company' => null,
			'order.address.vatid' => null, 'order.address.salutation' => 'mrs', 'order.address.title' => '',
			'order.address.firstname' => 'Adelheid', 'order.address.lastname' => 'Mustertest',
			'order.address.address1' => 'Königallee', 'order.address.address2' => '1', 'order.address.address3' => '',
			'order.address.postal' => '20146', 'order.address.city' => 'Hamburg', 'order.address.state' => 'Hamburg',
			'order.address.countryid' => 'de', 'order.address.languageid' => 'de', 'order.address.telephone' => '055544332211',
			'order.address.email' => 'test@example.com', 'order.address.telefax' => '055544332213',
			'order.address.website' => 'aimeos.org', 'order.address.longitude' => '10.0', 'order.address.latitude' => '50.0',
			'order.address.flag' => null
		]],
		'product' => [[
			'order.product.type' => 'default', 'order.product.prodcode' => 'CNE', 'order.product.suppliercode' => 'unitsupplier',
			'order.product.stocktype' => 'unit_type1', 'order.product.name' => 'Cafe Noire Expresso',
			'order.product.mediaurl' => 'somewhere/thump5.jpg', 'order.product.quantity' => 2, 'order.product.currencyid' => 'EUR',
			'order.product.price' => '36.00', 'order.product.costs' => '1.00', 'order.product.rebate' => '0.00',
			'order.product.taxrates' => ['' => '19.00'], 'order.product.taxflag' => 1, 'order.product.flags' => 1,
			'order.product.position' => 1, 'order.product.status' => 1,
			'coupon' => [[
				'order.coupon.code' => '5678'
			]]
		], [
			'order.product.type' => 'default', 'order.product.prodcode' => 'CNC', 'order.product.suppliercode' => 'unitsupplier',
			'order.product.stocktype' => 'unit_type2', 'order.product.name' => 'Cafe Noire Cappuccino',
			'order.product.mediaurl' => 'somewhere/thump6.jpg', 'order.product.quantity' => 1, 'order.product.currencyid' => 'EUR',
			'order.product.price' => '600.00', 'order.product.costs' => '30.00', 'order.product.rebate' => '0.00',
			'order.product.taxrates' => ['' => '19.00'], 'order.product.taxflag' => 1, 'order.product.flags' => 1,
			'order.product.position' => 2, 'order.product.status' => 1,
			'coupon' => [[
				'order.coupon.code' => 'OPQR'
			]]
		]],
		'service' => [[
			'order.service.serviceid' => 'unitpaymentcode', 'order.service.type' => 'payment', 'order.service.code' => 'OGONE',
			'order.service.name' => 'ogone', 'order.service.currencyid' => 'EUR', 'order.service.price' => '0.00',
			'order.service.costs' => '0.00', 'order.service.rebate' => '0.00', 'order.service.taxrates' => ['' => '0.00'],
			'order.service.mediaurl' => 'somewhere/thump1.jpg',
		], [
			'order.service.serviceid' => 'unitcode', 'order.service.type' => 'delivery', 'order.service.code' => 73,
			'order.service.name' => 'solucia', 'order.service.currencyid' => 'EUR', 'order.service.price' => '0.00',
			'order.service.costs' => '5.00', 'order.service.rebate' => '0.00', 'order.service.taxrates' => ['' => '0.00'],
			'order.service.mediaurl' => 'somewhere/thump1.jpg',
		]],
		'status' => [[
			'order.status.type' => 'typestatus', 'order.status.value' => 'waiting',
		]]
	], [
		'order.type' => 'web', 'order.statuspayment' => 5, 'order.statusdelivery' => 3,
		'order.datepayment' => '2011-09-17 16:14:32', 'order.datedelivery' => null, 'order.relatedid' => null,
		'order.customerid' => 'UTC001', 'order.sitecode' => 'unittest', 'order.languageid' => 'de', 'order.currencyid' => 'EUR',
		'order.price' => '13.50', 'order.costs' => '0.00', 'order.rebate' => '4.50', 'order.taxflag' => 1,
		'order.customerref' => 'XYZ-1234', 'order.comment' => 'This is a bundle basket.',
		'address' => [[
			'order.address.addressid' => 105, 'order.address.type' => 'delivery', 'order.address.company' => 'Example company',
			'order.address.vatid' => 'DE999999999', 'order.address.salutation' => 'mrs', 'order.address.title' => 'Dr.',
			'order.address.firstname' => 'Our', 'order.address.lastname' => 'Unittest',
			'order.address.address1' => 'Pickhuben', 'order.address.address2' => '2-4', 'order.address.address3' => '',
			'order.address.postal' => '20457', 'order.address.city' => 'Hamburg', 'order.address.state' => 'Hamburg',
			'order.address.countryid' => 'de', 'order.address.languageid' => 'de', 'order.address.telephone' => '055544332212',
			'order.address.email' => 'test@example.com', 'order.address.telefax' => '055544332212',
			'order.address.website' => 'www.example.com', 'order.address.longitude' => '10.5', 'order.address.latitude' => '51.0',
			'order.address.flag' => null
		], [
			'order.address.addressid' => 106, 'order.address.type' => 'payment', 'order.address.company' => null,
			'order.address.vatid' => null, 'order.address.salutation' => 'mr', 'order.address.title' => '',
			'order.address.firstname' => 'Our', 'order.address.lastname' => 'Unittest',
			'order.address.address1' => 'Durchschnitt', 'order.address.address2' => '2', 'order.address.address3' => '',
			'order.address.postal' => '20146', 'order.address.city' => 'Hamburg', 'order.address.state' => 'Hamburg',
			'order.address.countryid' => 'de', 'order.address.languageid' => 'de', 'order.address.telephone' => '055544332212',
			'order.address.email' => 'test@example.com', 'order.address.telefax' => '055544332213',
			'order.address.website' => 'aimeos.org', 'order.address.longitude' => '11.0', 'order.address.latitude' => '52.0',
			'order.address.flag' => null
		]],
		'product' => [[
			'order.product.type' => 'default', 'order.product.prodcode' => 'CNE',
			'order.product.suppliercode' => 'unitsupplier', 'order.product.stocktype' => 'unit_type1',
			'order.product.name' => 'Cafe Noire Expresso', 'order.product.mediaurl' => 'somewhere/thump1.jpg',
			'order.product.quantity' => 3, 'order.product.currencyid' => 'EUR', 'order.product.price' => '4.50',
			'order.product.costs' => '0.00', 'order.product.rebate' => '0.00', 'order.product.taxrates' => ['' => '0.00'],
			'order.product.taxflag' => 1, 'order.product.flags' => 0, 'order.product.position' => 1, 'order.product.status' => 1,
			'attribute' => [[
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'width',
				'order.product.attribute.value' => 32, 'order.product.name' => '32',
				'order.product.attribute.quantity' => 1,
			], [
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'length',
				'order.product.attribute.value' => 36, 'order.product.name' => '36',
				'order.product.attribute.quantity' => 1,
			]]
		], [
			'order.product.type' => 'default', 'order.product.prodcode' => 'ABCD',
			'order.product.suppliercode' => 'unitsupplier', 'order.product.stocktype' => 'unit_type1',
			'order.product.name' => '16 discs', 'order.product.mediaurl' => 'somewhere/thump4.jpg',
			'order.product.quantity' => 1, 'order.product.currencyid' => 'EUR', 'order.product.price' => '0.00',
			'order.product.costs' => '0.00', 'order.product.rebate' => '4.50', 'order.product.taxrates' => ['' => '0.00'],
			'order.product.taxflag' => 1, 'order.product.flags' => 0, 'order.product.position' => 2, 'order.product.status' => 1,
			'attribute' => [[
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'width',
				'order.product.attribute.value' => 32, 'order.product.name' => '32', 'order.product.attribute.quantity' => 1,
			], [
				'order.product.attribute.type' => 'default', 'order.product.attribute.code' => 'length',
				'order.product.attribute.value' => 30, 'order.product.name' => '30', 'order.product.attribute.quantity' => 1,
			]]
		]],
		'service' => [[
			'order.service.serviceid' => 'paypalexpress', 'order.service.type' => 'payment', 'order.service.code' => 'paypalexpress',
			'order.service.name' => 'paypal', 'order.service.currencyid' => 'EUR', 'order.service.price' => '0.00',
			'order.service.costs' => '0.00', 'order.service.rebate' => '0.00', 'order.service.taxrates' => ['' => '0.00'],
			'order.service.mediaurl' => 'somewhere/thump1.jpg',
		], [
			'order.service.serviceid' => 'unitcode', 'order.service.type' => 'delivery', 'order.service.code' => 73,
			'order.service.name' => 'solucia', 'order.service.currencyid' => 'EUR', 'order.service.price' => '0.00',
			'order.service.costs' => '5.00', 'order.service.rebate' => '0.00', 'order.service.taxrates' => ['' => '0.00'],
			'order.service.mediaurl' => 'somewhere/thump1.jpg',
		]],
		'status' => [[
			'order.status.type' => 'status', 'order.status.value' => 'waiting',
		]]
	], [
		'order.type' => 'web', 'order.statuspayment' => 6, 'order.statusdelivery' => 4, 'order.relatedid' => null,
		'order.datepayment' => '2009-03-18 16:14:32', 'order.datedelivery' => null,'order.customerid' => 'UTC001',
		'order.sitecode' => 'unittest', 'order.languageid' => 'de', 'order.currencyid' => 'EUR', 'order.price' => '4800.00',
		'order.costs' => '180.00', 'order.rebate' => '5.00', 'order.tax' => '718.8692', 'order.taxflag' => 1,
		'order.customerref' => 'XYZ-9876', 'order.comment' => 'This is a comment if an order. It can be added by the user.',
		'address' => [[
			'order.address.addressid' => 107, 'order.address.type' => 'payment', 'order.address.company' => null,
			'order.address.vatid' => null, 'order.address.salutation' => 'mrs', 'order.address.title' => '',
			'order.address.firstname' => 'Adelheid', 'order.address.lastname' => 'Mustertest',
			'order.address.address1' => 'Königallee', 'order.address.address2' => '1', 'order.address.address3' => '',
			'order.address.postal' => '20146', 'order.address.city' => 'Hamburg', 'order.address.state' => 'Hamburg',
			'order.address.countryid' => 'de', 'order.address.languageid' => 'de', 'order.address.telephone' => '055544332211',
			'order.address.email' => 'test@example.com', 'order.address.telefax' => '055544332213',
			'order.address.website' => 'aimeos.org', 'order.address.longitude' => '10.0', 'order.address.latitude' => '50.0',
			'order.address.flag' => null
		]],
		'product' => [[
			'order.product.type'=> 'bundle', 'order.product.prodcode' => 'bdl:zyx',
			'order.product.suppliercode' => 'unitsupplier', 'order.product.stocktype' => 'unit_type1',
			'order.product.name' => 'Bundle Unittest1', 'order.product.mediaurl' => 'somewhere/thump6.jpg',
			'order.product.quantity' => 1, 'order.product.currencyid' => 'EUR', 'order.product.price' => '1200.00',
			'order.product.costs' => '30.00', 'order.product.rebate' => '0.00', 'order.product.taxrates' => ['' => '17.00'],
			'order.product.taxflag' => 1, 'order.product.flags' => 0, 'order.product.position' => 1, 'order.product.status' => 1,
			'product' => [[
				'order.product.type' => 'default', 'order.product.prodcode' => 'bdl:EFG',
				'order.product.type' => 'default', 'order.product.suppliercode' => 'unitsupplier', 'order.product.stocktype' => 'unit_type1',
				'order.product.name' => 'Bundle Unittest1', 'order.product.mediaurl' => 'somewhere/thump6.jpg',
				'order.product.quantity' => 1, 'order.product.currencyid' => 'EUR', 'order.product.price' => '600.00',
				'order.product.costs' => '30.00', 'order.product.rebate' => '0.00', 'order.product.taxrates' => ['' => '16.00'],
				'order.product.taxflag' => 1, 'order.product.flags' => 0, 'order.product.position' => 2, 'order.product.status' => 1
			], [
				'order.product.type' => 'default', 'order.product.prodcode' => 'bdl:HIJ',
				'order.product.type' => 'default', 'order.product.suppliercode' => 'unitsupplier', 'order.product.stocktype' => 'unit_type1',
				'order.product.name' => 'Bundle Unittest 1', 'order.product.mediaurl' => 'somewhere/thump6.jpg',
				'order.product.quantity' => 1, 'order.product.currencyid' => 'EUR', 'order.product.price' => '600.00',
				'order.product.costs' => '30.00', 'order.product.rebate' => '0.00', 'order.product.taxrates' => ['' => '17.00'],
				'order.product.taxflag' => 1, 'order.product.flags' => 0, 'order.product.position' => 3, 'order.product.status' => 1
			]]
		], [
			'order.product.type'=> 'bundle', 'order.product.prodcode' => 'bdl:hal',
			'order.product.suppliercode' => 'unitsupplier', 'order.product.stocktype' => 'unit_type1',
			'order.product.name' => 'Bundle Unittest2', 'order.product.mediaurl' => 'somewhere/thump6.jpg',
			'order.product.quantity' => 1, 'order.product.currencyid' => 'EUR', 'order.product.price' => '1200.00',
			'order.product.costs' => '30.00', 'order.product.rebate' => '0.00', 'order.product.taxrates' => ['' => '17.00'],
			'order.product.taxflag' => 1, 'order.product.flags' => 0, 'order.product.position' => 4, 'order.product.status' => 1,
			'product' => [[
				'order.product.type' => 'default', 'order.product.prodcode' => 'bdl:EFX',
				'order.product.type' => 'default', 'order.product.suppliercode' => 'unitsupplier', 'order.product.stocktype' => 'unit_type1',
				'order.product.name' => 'Bundle Unittest 2', 'order.product.mediaurl' => 'somewhere/thump6.jpg',
				'order.product.quantity' => 1, 'order.product.currencyid' => 'EUR', 'order.product.price' => '600.00',
				'order.product.costs' => '30.00', 'order.product.rebate' => '0.00', 'order.product.taxrates' => ['' => '16.00'],
				'order.product.taxflag' => 1, 'order.product.flags' => 0, 'order.product.position' => 5, 'order.product.status' => 1
			], [
				'order.product.type' => 'default', 'order.product.prodcode' => 'bdl:HKL',
				'order.product.type' => 'default', 'order.product.suppliercode' => 'unitsupplier', 'order.product.stocktype' => 'unit_type1',
				'order.product.name' => 'Bundle Unittest 2', 'order.product.mediaurl' => 'somewhere/thump6.jpg',
				'order.product.quantity' => 1, 'order.product.currencyid' => 'EUR', 'order.product.price' => '600.00',
				'order.product.costs' => '30.00', 'order.product.rebate' => '0.00', 'order.product.taxrates' => ['' => '18.00'],
				'order.product.taxflag' => 1, 'order.product.flags' => 0, 'order.product.position' => 6, 'order.product.status' => 1
			]]
		]],
		'service' => [[
			'order.service.serviceid' => 'directdebit-test', 'order.service.type' => 'payment', 'order.service.code' => 'directdebit-test',
			'order.service.name' => 'DirectDebit', 'order.service.currencyid' => 'EUR', 'order.service.price' => '0.00',
			'order.service.costs' => '0.00', 'order.service.rebate' => '0.00', 'order.service.taxrates' => ['' => '0.00'],
			'order.service.mediaurl' => 'somewhere/thump1.jpg',
		], [
			'order.service.serviceid' => 'unitcode', 'order.service.type' => 'delivery', 'order.service.code' => 73,
			'order.service.name' => 'solucia', 'order.service.currencyid' => 'EUR', 'order.service.price' => '0.00',
			'order.service.costs' => '5.00', 'order.service.rebate' => '0.00', 'order.service.taxrates' => ['' => '0.00'],
			'order.service.mediaurl' => 'somewhere/thump1.jpg',
		]]
	]],
];
