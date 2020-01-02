<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 */


return array(
	'manager' => array(
		'address' => array(
			'standard' => array(
				'aggregate' => array(
					'ansi' => '
						SELECT "key", COUNT("val") AS "count"
						FROM (
							SELECT :key AS "key", :val AS "val"
							FROM "mshop_order_address" AS mordad
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					'
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "mshop_order_address"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "mshop_order_address" ( :names
							"orderid", "addrid", "type", "company", "vatid", "salutation",
							"title", "firstname", "lastname", "address1", "address2",
							"address3", "postal", "city", "state", "countryid", "langid",
							"telephone", "email", "telefax", "website", "longitude", "latitude",
							"pos", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "mshop_order_address"
						SET :names
							"orderid" = ?, "addrid" = ?, "type" = ?, "company" = ?, "vatid" = ?,
							"salutation" = ?, "title" = ?, "firstname" = ?, "lastname" = ?,
							"address1" = ?, "address2" = ?, "address3" = ?, "postal" = ?,
							"city" = ?, "state" = ?, "countryid" = ?, "langid" = ?,
							"telephone" = ?, "email" = ?, "telefax" = ?, "website" = ?,
							"longitude" = ?, "latitude" = ?, "pos" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mordad."id" AS "order.address.id", mordad."orderid" AS "order.address.orderid",
							mordad."siteid" AS "order.address.siteid", mordad."addrid" AS "order.address.addressid",
							mordad."type" AS "order.address.type", mordad."company" AS "order.address.company",
							mordad."vatid" AS "order.address.vatid", mordad."salutation" AS "order.address.salutation",
							mordad."title" AS "order.address.title", mordad."firstname" AS "order.address.firstname",
							mordad."lastname" AS "order.address.lastname", mordad."address1" AS "order.address.address1",
							mordad."address2" AS "order.address.address2", mordad."address3" AS "order.address.address3",
							mordad."postal" AS "order.address.postal", mordad."city" AS "order.address.city",
							mordad."state" AS "order.address.state", mordad."countryid" AS "order.address.countryid",
							mordad."langid" AS "order.address.languageid", mordad."telephone" AS "order.address.telephone",
							mordad."email" AS "order.address.email", mordad."telefax" AS "order.address.telefax",
							mordad."website" AS "order.address.website", mordad."longitude" AS "order.address.longitude",
							mordad."latitude" AS "order.address.latitude", mordad."pos" AS "order.address.position",
							mordad."mtime" AS "order.address.mtime", mordad."editor" AS "order.address.editor",
							mordad."ctime" AS "order.address.ctime"
						FROM "mshop_order_address" AS mordad
						:joins
						WHERE :cond
						GROUP BY :columns
							mordad."id", mordad."orderid", mordad."siteid", mordad."addrid", mordad."company",
							mordad."vatid", mordad."salutation", mordad."title", mordad."firstname", mordad."lastname",
							mordad."address1", mordad."address2", mordad."address3", mordad."postal", mordad."city",
							mordad."state", mordad."countryid", mordad."langid", mordad."telephone", mordad."email",
							mordad."telefax", mordad."website", mordad."longitude", mordad."latitude", mordad."pos",
							mordad."mtime", mordad."editor", mordad."ctime"
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT( DISTINCT mordad."id" ) AS "count"
						FROM "mshop_order_address" AS mordad
						:joins
						WHERE :cond
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT mshop_order_address_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'coupon' => array(
			'standard' => array(
				'aggregate' => array(
					'ansi' => '
						SELECT "key", COUNT("val") AS "count"
						FROM (
							SELECT :key AS "key", :val AS "val"
							FROM "mshop_order_coupon" AS mordco
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					'
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "mshop_order_coupon"
						WHERE :cond AND siteid = ?
						'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "mshop_order_coupon" ( :names
							"orderid", "ordprodid", "code", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "mshop_order_coupon"
						SET :names
							"orderid" = ?, "ordprodid" = ?, "code" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mordco."id" AS "order.coupon.id", mordco."orderid" AS "order.coupon.orderid",
							mordco."siteid" AS "order.coupon.siteid", mordco."ordprodid" AS "order.coupon.ordprodid",
							mordco."code" AS "order.coupon.code", mordco."mtime" AS "order.coupon.mtime",
							mordco."editor" AS "order.coupon.editor", mordco."ctime" AS "order.coupon.ctime"
						FROM "mshop_order_coupon" AS mordco
						:joins
						WHERE :cond
						GROUP BY :columns
							mordco."id", mordco."orderid", mordco."siteid", mordco."ordprodid",
							mordco."code", mordco."mtime", mordco."editor", mordco."ctime"
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT( DISTINCT mordco."id" ) AS "count"
						FROM "mshop_order_coupon" AS mordco
						:joins
						WHERE :cond
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT mshop_order_coupon_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'product' => array(
			'attribute' => array(
				'standard' => array(
					'aggregate' => array(
						'ansi' => '
							SELECT "key", COUNT("val") AS "count"
							FROM (
								SELECT :key AS "key", :val AS "val"
								FROM "mshop_order_product_attr" AS mordprat
								:joins
								WHERE :cond
								/*-orderby*/ ORDER BY :order /*orderby-*/
								LIMIT :size OFFSET :start
							) AS list
							GROUP BY "key"
						'
					),
					'delete' => array(
						'ansi' => '
							DELETE FROM "mshop_order_product_attr"
							WHERE :cond AND siteid = ?
						'
					),
					'insert' => array(
						'ansi' => '
							INSERT INTO "mshop_order_product_attr" ( :names
								"attrid", "parentid", "type", "code", "value",
								"quantity", "name", "mtime", "editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						'
					),
					'update' => array(
						'ansi' => '
							UPDATE "mshop_order_product_attr"
							SET :names
								"attrid" = ?, "parentid" = ?, "type" = ?, "code" = ?,
								"value" = ?, "quantity" = ?, "name" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" = ? AND "id" = ?
						'
					),
					'search' => array(
						'ansi' => '
							SELECT :columns
								mordprat."id" AS "order.product.attribute.id", mordprat."siteid" AS "order.product.attribute.siteid",
								mordprat."attrid" AS "order.product.attribute.attributeid", mordprat."parentid" AS "order.product.attribute.parentid",
								mordprat."type" AS "order.product.attribute.type", mordprat."code" AS "order.product.attribute.code",
								mordprat."value" AS "order.product.attribute.value", mordprat."quantity" AS "order.product.attribute.quantity",
								mordprat."name" AS "order.product.attribute.name", mordprat."mtime" AS "order.product.attribute.mtime",
								mordprat."editor" AS "order.product.attribute.editor", mordprat."ctime" AS "order.product.attribute.ctime"
							FROM "mshop_order_product_attr" AS mordprat
							:joins
							WHERE :cond
							GROUP BY :columns
								mordprat."id", mordprat."siteid", mordprat."attrid", mordprat."parentid", mordprat."type",
								mordprat."code", mordprat."quantity", mordprat."value", mordprat."name", mordprat."mtime",
								mordprat."editor", mordprat."ctime"
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						'
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT( DISTINCT mordprat."id" ) AS "count"
							FROM "mshop_order_product_attr" AS mordprat
							:joins
							WHERE :cond
						'
					),
					'newid' => array(
						'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
						'mysql' => 'SELECT LAST_INSERT_ID()',
						'oracle' => 'SELECT mshop_order_product_attr_seq.CURRVAL FROM DUAL',
						'pgsql' => 'SELECT lastval()',
						'sqlite' => 'SELECT last_insert_rowid()',
						'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
						'sqlanywhere' => 'SELECT @@IDENTITY',
					),
				),
			),
			'standard' => array(
				'aggregate' => array(
					'ansi' => '
						SELECT "key", COUNT("val") AS "count"
						FROM (
							SELECT :key AS "key", :val AS "val"
							FROM "mshop_order_product" AS mordpr
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					'
				),
				'aggregateavg' => array(
					'ansi' => '
						SELECT "key", AVG("val") AS "count"
						FROM (
							SELECT :key AS "key", :val AS "val"
							FROM "mshop_order_product" AS mordpr
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					'
				),
				'aggregatesum' => array(
					'ansi' => '
						SELECT "key", SUM("val") AS "count"
						FROM (
							SELECT :key AS "key", :val AS "val"
							FROM "mshop_order_product" AS mordpr
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					'
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "mshop_order_product"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "mshop_order_product" ( :names
							"orderid", "ordprodid", "ordaddrid", "type", "prodid", "prodcode", "suppliercode",
							"stocktype", "name", "description", "mediaurl", "timeframe", "quantity",
							"currencyid", "price", "costs", "rebate", "tax", "taxrate", "taxflag",
							"flags", "status", "pos", "mtime", "editor", "target", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "mshop_order_product"
						SET :names
							"orderid" = ?, "ordprodid" = ?, "ordaddrid" = ?, "type" = ?,
							"prodid" = ?, "prodcode" = ?, "suppliercode" = ?, "stocktype" = ?,
							"name" = ?, "description" = ?, "mediaurl" = ?, "timeframe" = ?,
							"quantity" = ?, "currencyid" = ?, "price" = ?, "costs" = ?,
							"rebate" = ?, "tax" = ?, "taxrate" = ?, "taxflag" = ?, "flags" = ?,
							"status" = ?, "pos" = ?, "mtime" = ?, "editor" = ?, "target" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mordpr."id" AS "order.product.id", mordpr."orderid" AS "order.product.orderid",
							mordpr."siteid" AS "order.product.siteid", mordpr."ordprodid" AS "order.product.orderproductid",
							mordpr."prodid" AS "order.product.productid", mordpr."prodcode" AS "order.product.prodcode",
							mordpr."suppliercode" AS "order.product.suppliercode", mordpr."stocktype" AS "order.product.stocktype",
							mordpr."type" AS "order.product.type", mordpr."name" AS "order.product.name",
							mordpr."mediaurl" AS "order.product.mediaurl", mordpr."timeframe" AS "order.product.timeframe",
							mordpr."quantity" AS "order.product.quantity", mordpr."currencyid" AS "order.product.currencyid",
							mordpr."price" AS "order.product.price", mordpr."costs" AS "order.product.costs",
							mordpr."rebate" AS "order.product.rebate", mordpr."tax" AS "order.product.tax",
							mordpr."taxrate" AS "order.product.taxrates", mordpr."taxflag" AS "order.product.taxflag",
							mordpr."flags" AS "order.product.flags", mordpr."status" AS "order.product.status",
							mordpr."pos" AS "order.product.position", mordpr."mtime" AS "order.product.mtime",
							mordpr."editor" AS "order.product.editor", mordpr."ctime" AS "order.product.ctime",
							mordpr."target" AS "order.product.target", mordpr."ordaddrid" AS "order.product.orderaddressid",
							mordpr."description" AS "order.product.description"
						FROM "mshop_order_product" AS mordpr
						:joins
						WHERE :cond
						GROUP BY :columns
							mordpr."id", mordpr."orderid", mordpr."siteid", mordpr."ordprodid", mordpr."prodid",
							mordpr."prodcode", mordpr."suppliercode", mordpr."stocktype", mordpr."type", mordpr."name",
							mordpr."mediaurl", mordpr."timeframe", mordpr."quantity", mordpr."currencyid", mordpr."price",
							mordpr."costs", mordpr."rebate", mordpr."tax", mordpr."taxrate", mordpr."taxflag", mordpr."flags",
							mordpr."status", mordpr."pos", mordpr."mtime", mordpr."editor", mordpr."target", mordpr."ctime",
							mordpr."ordaddrid", mordpr."description"
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT( DISTINCT mordpr."id" ) AS "count"
						FROM "mshop_order_product" AS mordpr
						:joins
						WHERE :cond
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT mshop_order_product_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'service' => array(
			'attribute' => array(
				'standard' => array(
					'aggregate' => array(
						'ansi' => '
							SELECT "key", COUNT("val") AS "count"
							FROM (
								SELECT :key AS "key", :val AS "val"
								FROM "mshop_order_service_attr" AS mordseat
								:joins
								WHERE :cond
								/*-orderby*/ ORDER BY :order /*orderby-*/
								LIMIT :size OFFSET :start
							) AS list
							GROUP BY "key"
						'
					),
					'delete' => array(
						'ansi' => '
							DELETE FROM "mshop_order_service_attr"
							WHERE :cond AND siteid = ?
						'
					),
					'insert' => array(
						'ansi' => '
							INSERT INTO "mshop_order_service_attr" ( :names
								"attrid", "parentid", "type", "code", "value",
								"quantity", "name", "mtime", "editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						'
					),
					'update' => array(
						'ansi' => '
							UPDATE "mshop_order_service_attr"
							SET :names
								"attrid" = ?, "parentid" = ?, "type" = ?, "code" = ?,
								"value" = ?, "quantity" = ?, "name" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" = ? AND "id" = ?
						'
					),
					'search' => array(
						'ansi' => '
							SELECT :columns
								mordseat."id" AS "order.service.attribute.id", mordseat."siteid" AS "order.service.attribute.siteid",
								mordseat."attrid" AS "order.service.attribute.attributeid", mordseat."parentid" AS "order.service.attribute.parentid",
								mordseat."type" AS "order.service.attribute.type", mordseat."code" AS "order.service.attribute.code",
								mordseat."value" AS "order.service.attribute.value", mordseat."quantity" AS "order.service.attribute.quantity",
								mordseat."name" AS "order.service.attribute.name", mordseat."mtime" AS "order.service.attribute.mtime",
								mordseat."ctime" AS "order.service.attribute.ctime", mordseat."editor" AS "order.service.attribute.editor"
							FROM "mshop_order_service_attr" AS mordseat
							:joins
							WHERE :cond
							GROUP BY :columns
								mordseat."id", mordseat."siteid", mordseat."attrid", mordseat."parentid", mordseat."type",
								mordseat."code", mordseat."value", mordseat."quantity", mordseat."name", mordseat."mtime",
								mordseat."ctime", mordseat."editor"
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						'
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT( DISTINCT mordseat."id" ) AS "count"
							FROM "mshop_order_service_attr" AS mordseat
							:joins
							WHERE :cond
						'
					),
					'newid' => array(
						'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
						'mysql' => 'SELECT LAST_INSERT_ID()',
						'oracle' => 'SELECT mshop_order_service_attr_seq.CURRVAL FROM DUAL',
						'pgsql' => 'SELECT lastval()',
						'sqlite' => 'SELECT last_insert_rowid()',
						'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
						'sqlanywhere' => 'SELECT @@IDENTITY',
					),
				),
			),
			'standard' => array(
				'aggregate' => array(
					'ansi' => '
						SELECT "key", COUNT("val") AS "count"
						FROM (
							SELECT :key AS "key", :val AS "val"
							FROM "mshop_order_service" AS mordse
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					'
				),
				'aggregateavg' => array(
					'ansi' => '
						SELECT "key", AVG("val") AS "count"
						FROM (
							SELECT :key AS "key", :val AS "val"
							FROM "mshop_order_service" AS mordse
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					'
				),
				'aggregatesum' => array(
					'ansi' => '
						SELECT "key", SUM("val") AS "count"
						FROM (
							SELECT :key AS "key", :val AS "val"
							FROM "mshop_order_service" AS mordse
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					'
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "mshop_order_service"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "mshop_order_service" ( :names
							"orderid", "servid", "type", "code", "name", "mediaurl",
							"currencyid", "price", "costs", "rebate", "tax", "taxrate",
							"taxflag", "pos", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "mshop_order_service"
						SET :names
							"orderid" = ?, "servid" = ?, "type" = ?, "code" = ?,
							"name" = ?, "mediaurl" = ?, "currencyid" = ?, "price" = ?,
							"costs" = ?, "rebate" = ?, "tax" = ?, "taxrate" = ?,
							"taxflag" = ?, "pos" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mordse."id" AS "order.service.id", mordse."orderid" AS "order.service.orderid",
							mordse."siteid" AS "order.service.siteid", mordse."servid" AS "order.service.serviceid",
							mordse."type" AS "order.service.type", mordse."code" AS "order.service.code",
							mordse."name" AS "order.service.name", mordse."mediaurl" AS "order.service.mediaurl",
							mordse."currencyid" AS "order.service.currencyid", mordse."price" AS "order.service.price",
							mordse."costs" AS "order.service.costs", mordse."rebate" AS "order.service.rebate",
							mordse."tax" AS "order.service.tax", mordse."taxrate" AS "order.service.taxrates",
							mordse."taxflag" AS "order.service.taxflag", mordse."pos" AS "order.service.position",
							mordse."mtime" AS "order.service.mtime", mordse."editor" AS "order.service.editor",
							mordse."ctime" AS "order.service.ctime"
						FROM "mshop_order_service" AS mordse
						:joins
						WHERE :cond
						GROUP BY :columns
							mordse."id", mordse."orderid", mordse."siteid", mordse."servid",
							mordse."type", mordse."code", mordse."name", mordse."mediaurl",
							mordse."currencyid", mordse."price", mordse."costs", mordse."rebate",
							mordse."tax", mordse."taxrate", mordse."taxflag", mordse."pos",
							mordse."mtime", mordse."editor", mordse."ctime"
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT( DISTINCT mordse."id" ) AS "count"
						FROM "mshop_order_service" AS mordse
						:joins
						WHERE :cond
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT mshop_order_service_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'status' => array(
			'standard' => array(
				'aggregate' => array(
					'ansi' => '
						SELECT "key", COUNT("val") AS "count"
						FROM (
							SELECT :key AS "key", :val AS "val"
							FROM "mshop_order_status" AS mordst
							:joins
							WHERE :cond
							/*-orderby*/ ORDER BY :order /*orderby-*/
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
					'
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "mshop_order_status"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "mshop_order_status" ( :names
							"parentid", "type", "value", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "mshop_order_status"
						SET :names
							"parentid" = ?, "type" = ?, "value" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mordst."id" AS "order.status.id", mordst."siteid" AS "order.status.siteid",
							mordst."parentid" AS "order.status.parentid", mordst."type" AS "order.status.type",
							mordst."value" AS "order.status.value", mordst."mtime" AS "order.status.mtime",
							mordst."ctime" AS "order.status.ctime", mordst."editor" AS "order.status.editor"
						FROM "mshop_order_status" AS mordst
						:joins
						WHERE :cond
						GROUP BY :columns
							mordst."id", mordst."siteid", mordst."parentid", mordst."type",
							mordst."value", mordst."mtime", mordst."ctime", mordst."editor"
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT( DISTINCT mordst."id" ) AS "count"
						FROM "mshop_order_status" AS mordst
						:joins
						WHERE :cond
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT mshop_order_status_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'standard' => array(
			'aggregate' => array(
				'ansi' => '
					SELECT "key", COUNT("val") AS "count"
					FROM (
						SELECT :key AS "key", :val AS "val"
						FROM "mshop_order" AS mord
						:joins
						WHERE :cond
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					) AS list
					GROUP BY "key"
				'
			),
			'aggregateavg' => array(
				'ansi' => '
					SELECT "key", AVG("val") AS "count"
					FROM (
						SELECT :key AS "key", :val AS "val"
						FROM "mshop_order" AS mord
						:joins
						WHERE :cond
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					) AS list
					GROUP BY "key"
				'
			),
			'aggregatesum' => array(
				'ansi' => '
					SELECT "key", SUM("val") AS "count"
					FROM (
						SELECT :key AS "key", :val AS "val"
						FROM "mshop_order" AS mord
						:joins
						WHERE :cond
						/*-orderby*/ ORDER BY :order /*orderby-*/
						LIMIT :size OFFSET :start
					) AS list
					GROUP BY "key"
				'
			),
			'insert' => array(
				'ansi' => '
					INSERT INTO "mshop_order" ( :names
						"type", "datepayment", "datedelivery",
						"statusdelivery", "statuspayment", "relatedid",
						"customerid", "sitecode", "langid", "currencyid",
						"price", "costs", "rebate", "tax", "taxflag",
						"customerref", "comment", "mtime", "editor", "siteid",
						"ctime", "cdate", "cmonth", "cweek", "cwday", "chour"
					) VALUES ( :values
						?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
					)
				'
			),
			'update' => array(
				'ansi' => '
					UPDATE "mshop_order"
					SET :names
						"type" = ?, "datepayment" = ?, "datedelivery" = ?, "statusdelivery" = ?,
						"statuspayment" = ?, "relatedid" = ?, "customerid" = ?, "sitecode" = ?, "langid" = ?,
						"currencyid" = ?, "price" = ?, "costs" = ?, "rebate" = ?, "tax" = ?, "taxflag" = ?,
						"customerref" = ?, "comment" = ?, "mtime" = ?, "editor" = ?
					WHERE "siteid" = ? AND "id" = ?
				'
			),
			'delete' => array(
				'ansi' => '
					DELETE FROM "mshop_order"
					WHERE :cond AND siteid = ?
				'
			),
			'search' => array(
				'ansi' => '
					SELECT :columns
						mord."id" AS "order.id", mord."siteid" AS "order.siteid", mord."type" AS "order.type",
						mord."datepayment" AS "order.datepayment", mord."datedelivery" AS "order.datedelivery",
						mord."statuspayment" AS "order.statuspayment", mord."statusdelivery" AS "order.statusdelivery",
						mord."relatedid" AS "order.relatedid", mord."sitecode" AS "order.sitecode",
						mord."customerid" AS "order.customerid", mord."langid" AS "order.languageid",
						mord."currencyid" AS "order.currencyid", mord."price" AS "order.price",
						mord."costs" AS "order.costs", mord."rebate" AS "order.rebate",
						mord."tax" AS "order.tax", mord."taxflag" AS "order.taxflag",
						mord."customerref" AS "order.customerref", mord."comment" AS "order.comment",
						mord."ctime" AS "order.ctime", mord."mtime" AS "order.mtime", mord."editor" AS "order.editor"
					FROM "mshop_order" AS mord
					:joins
					WHERE :cond
					GROUP BY :columns
						mord."id", mord."siteid", mord."type", mord."datepayment",
						mord."datedelivery", mord."statuspayment", mord."statusdelivery", mord."relatedid",
						mord."sitecode", mord."customerid", mord."langid", mord."currencyid", mord."price",
						mord."costs", mord."rebate", mord."tax", mord."taxflag", mord."comment", mord."customerref",
						mord."ctime", mord."mtime", mord."editor"
					/*-orderby*/ ORDER BY :order /*orderby-*/
					LIMIT :size OFFSET :start
				'
			),
			'count' => array(
				'ansi' => '
					SELECT COUNT( DISTINCT mord."id" ) AS "count"
					FROM "mshop_order" AS mord
					:joins
					WHERE :cond
				'
			),
			'newid' => array(
				'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
				'mysql' => 'SELECT LAST_INSERT_ID()',
				'oracle' => 'SELECT mshop_order_seq.CURRVAL FROM DUAL',
				'pgsql' => 'SELECT lastval()',
				'sqlite' => 'SELECT last_insert_rowid()',
				'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
				'sqlanywhere' => 'SELECT @@IDENTITY',
			),
		),
	),
);
