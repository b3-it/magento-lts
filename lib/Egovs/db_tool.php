<?php
error_reporting( E_ALL ^ E_NOTICE );
ob_start();

$ds         = DIRECTORY_SEPARATOR;  // System-Seperator verwenden
$sub[]      = $ds . join($ds, array('lib', 'egovs'));
$sub[]      = $ds . join($ds, array('lib', 'Egovs'));
$base       = str_replace( $sub, '', dirname(__FILE__) );
$config_xml = $base . $ds . join($ds, array('app', 'etc', 'local.xml'));
$script     = str_replace('\\', '/', $_SERVER['PHP_SELF']);
$data_xml   = array();

// Per Default kann weder die DB gelöscht werden, noch die Anonymisierung genutzt werden
// Der Wert muss manuell auf FALSE gesetzt werden, um die Funktion zu nutzen
$resticted_host = TRUE;

if ( is_file('.localhost') ) {
    $resticted_host = FALSE;
}

/////////////////////// Letzte Fehlermeldung \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
$last_err = null;

/////////////////////// SQL-Abfragen \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
$sql = array(
		'deleteLog' => array(
				1  => array(
						'action' => 'log_customer',
						'query'  => 'TRUNCATE `log_customer`;',
                        'after'  => 'ALTER TABLE `log_customer` AUTO_INCREMENT=1;',
				),
				2  => array(
						'action' => 'log_quote',
						'query'  => 'TRUNCATE `log_quote`;',
                        'after'  => 'ALTER TABLE `log_quote` AUTO_INCREMENT=1;',
				),
				3  => array(
						'action' => 'log_summary',
						'query'  => 'TRUNCATE `log_summary`;',
                        'after'  => 'ALTER TABLE `log_summary` AUTO_INCREMENT=1;',
				),
				4  => array(
						'action' => 'log_summary_type',
						'query'  => 'TRUNCATE `log_summary_type`;',
                        'after'  => 'ALTER TABLE `log_summary_type` AUTO_INCREMENT=1;',
				),
				5  => array(
						'action' => 'log_url',
						'query'  => 'TRUNCATE `log_url`;',
                        'after'  => 'ALTER TABLE `log_url` AUTO_INCREMENT=1;',
				),
				6  => array(
						'action' => 'log_url_info',
						'query'  => 'TRUNCATE `log_url_info`;',
                        'after'  => 'ALTER TABLE `log_url_info` AUTO_INCREMENT=1;',
				),
				7  => array(
						'action' => 'log_visitor',
						'query'  => 'TRUNCATE `log_visitor`;',
                        'after'  => 'ALTER TABLE `log_visitor` AUTO_INCREMENT=1;',
				),
				8  => array(
						'action' => 'log_visitor_info',
						'query'  => 'TRUNCATE `log_visitor_info`;',
                        'after'  => 'ALTER TABLE `log_visitor_info` AUTO_INCREMENT=1;',
				),
				9  => array(
						'action' => 'log_visitor_online',
						'query'  => 'TRUNCATE `log_visitor_online`;',
                        'after'  => 'ALTER TABLE `log_visitor_online` AUTO_INCREMENT=1;',
				),
		),
		'anonUser' => array(
				1  => array(
						'action' => 'anon_customer_create',
						'query'  => "ALTER TABLE `customer_entity` CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT 0;"
				),
				2  => array(
						'action' => 'anon_customer_update',
						'query'  => "ALTER TABLE `customer_entity` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT 0;"
				),
				3  => array(
						'action' => 'anon_customer_email',
						'query'  => "UPDATE `customer_entity` SET `email` = CONCAT('anon_',entity_id,'@testshop.org') WHERE `email` NOT LIKE '%testshop.org' OR `email` NOT LIKE '%trw-net.de' OR `email` NOT LIKE '%hempelfernsehen.de';"
				),
				4  => array(
						'action' => 'anon_sales_email_quote',
						'query'  => "UPDATE `sales_flat_quote` SET `customer_email` = CONCAT('anon_',customer_id,'@testshop.org') WHERE `customer_email` NOT LIKE '%testshop.org' OR `customer_email` NOT LIKE '%trw-net.de' OR `customer_email` NOT LIKE '%hempelfernsehen.de';"
				),
				5  => array(
						'action' => 'anon_sales_flat_order_names',
						'query'  => "UPDATE `sales_flat_order` SET `customer_firstname` = CONCAT('firstname_',customer_id), `customer_lastname` = CONCAT('lastname_',customer_id), `customer_company` = CONCAT('company_',customer_id), `remote_ip` = '0.0.0.0';"
				),
				6  => array(
						'action' => 'anon_sales_email_order',
						'query'  => "UPDATE `sales_flat_order` SET `customer_email` = CONCAT('anon_',customer_id,'@testshop.org') WHERE `customer_email` NOT LIKE '%testshop.org' OR `customer_email` NOT LIKE '%trw-net.de' OR `customer_email` NOT LIKE '%hempelfernsehen.de';"
				),
				7  => array(
						'action' => 'anon_sales_addess_quote',
						'query'  => "UPDATE `sales_flat_quote_address` SET `firstname` = CONCAT('firstname_',customer_id), `lastname` = CONCAT('lastname_',customer_id), `company` = CONCAT('company_',customer_id), `company2` = CONCAT('company2_',customer_id) , `company3` = CONCAT('company3_',customer_id) ;"
				),
				8  => array(
						'action' => 'anon_sales_addess_order',
						'query'  => "UPDATE `sales_flat_order_address` SET `firstname` = CONCAT('firstname_',customer_id), `lastname` = CONCAT('lastname_',customer_id), `company` = CONCAT('company_',customer_id), `company2` = CONCAT('company2_',customer_id) , `company3` = CONCAT('company3_',customer_id), `telephone` = '', `street` = CONCAT('Teststrasse ',entity_id);"
				),
				9  => array(
						'action' => 'anon_cusomer_firstname',
						'query'  => "UPDATE `customer_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'firstname' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer' SET `value` = CONCAT('firstname_',entity_id);"
				),
				10 => array(
						'action' => 'anon_cusomer_lastname',
						'query'  => "UPDATE `customer_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'lastname' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer' SET `value` = CONCAT('lastname_',entity_id);"
				),
				11 => array(
						'action' => 'anon_cusomer_company',
						'query'  => "UPDATE `customer_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer' SET `value` = CONCAT('company_',entity_id);"
				),
				12 => array(
						'action' => 'anon_cusomer_company2',
						'query'  => "UPDATE `customer_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company2' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer' SET `value` = CONCAT('company2_',entity_id);"
				),
				13 => array(
						'action' => 'anon_cusomer_company3',
						'query'  => "UPDATE `customer_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company3' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer' SET `value` = CONCAT('company3_',entity_id);"
				),
				14 => array(
						'action' => 'anon_address_firstname',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'firstname' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('firstname_',entity_id);"
				),
				15 => array(
						'action' => 'anon_address_lastname',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'lastname' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('lastname_',entity_id);"
				),
				16 => array(
						'action' => 'anon_address_company',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('company_',entity_id);"
				),
				17 => array(
						'action' => 'anon_address_company2',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company2' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('company2_',entity_id);"
				),
				18 => array(
						'action' => 'anon_address_company3',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company3' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('company3_',entity_id);"
				),
				19 => array(
						'action' => 'anon_address_phone',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'telephone' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = '';"
				),
				20 => array(
						'action' => 'anon_address_street',
						'query'  => "UPDATE `customer_address_entity_text` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'street' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('Teststrasse ',entity_id);"
				),
				21 => array(
						'action' => 'anon_address_city',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'city' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = 'Testort';"
				),
				22 => array(
						'action' => 'anon_address_postcode',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'postcode' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = '12345';"
				),
				23 => array(
						'action' => 'anon_address_email',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'email' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('anon_',entity_id,'@testshop.org') WHERE `value` NOT LIKE '%testshop.org' OR `value` NOT LIKE '%trw-net.de' OR `value` NOT LIKE '%hempelfernsehen.de';"
				),
				24 => array(
						'action' => 'anon_billing_invoice_grid',
						'query'  => "UPDATE `sales_flat_invoice_grid` SET `billing_name` = CONCAT('billing_name',increment_id), billing_company = CONCAT('billing_company',increment_id);"
				),
				25 => array(
						'action' => 'anon_billing_order_grid',
						'query'  => "UPDATE `sales_flat_order_grid` SET `billing_name` = CONCAT('billing_name',increment_id), billing_company = CONCAT('billing_company',increment_id), shipping_name = CONCAT('shipping_name',increment_id),  shipping_company = CONCAT('shipping_company',increment_id);"
				),
				26 => array(
						'action' => 'anon_delete_newsletter',
						'query'  => "DELETE IGNORE FROM `newsletter_subscriber`;"
				),
				27 => array(
						'action' => 'anon_delete_email_queue',
						'query'  => "DELETE IGNORE FROM `core_email_queue`;"
				),
				28 => array(
						'action' => 'anon_dataflow_batch_import',
						'query'  => "UPDATE `dataflow_batch_import` SET `batch_data` = ''"
				),
		),
        'cleanCustomer' => array(
        		1 => array(
                        'action' => 'clean_customer_address_entity',
                        'query'  => 'TRUNCATE `customer_address_entity`;',
                        'after'  => 'ALTER TABLE `customer_address_entity` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                2 => array(
                        'action' => 'clean_customer_address_entity_datetime',
                        'query'  => 'TRUNCATE `customer_address_entity_datetime`;',
                        'after'  => 'ALTER TABLE `customer_address_entity_datetime` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                3 => array(
                        'action' => 'clean_customer_address_entity_decimal',
                        'query'  => 'TRUNCATE `customer_address_entity_decimal`;',
                        'after'  => 'ALTER TABLE `customer_address_entity_decimal` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                4 => array(
                        'action' => 'clean_customer_address_entity_int',
                        'query'  => 'TRUNCATE `customer_address_entity_int`;',
                        'after'  => 'ALTER TABLE `customer_address_entity_int` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                5 => array(
                        'action' => 'clean_customer_address_entity_text',
                        'query'  => 'TRUNCATE `customer_address_entity_text`;',
                        'after'  => 'ALTER TABLE `customer_address_entity_text` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                6 => array(
                        'action' => 'clean_customer_address_entity_varchar',
                        'query'  => 'TRUNCATE `customer_address_entity_varchar`;',
                        'after'  => 'ALTER TABLE `customer_address_entity_varchar` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                7 => array(
                        'action' => 'clean_customer_entity',
                        'query'  => 'TRUNCATE `customer_entity`;',
                        'after'  => 'ALTER TABLE `customer_entity` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                8 => array(
                        'action' => 'clean_customer_entity_datetime',
                        'query'  => 'TRUNCATE `customer_entity_datetime`;',
                        'after'  => 'ALTER TABLE `customer_entity_datetime` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                9 => array(
                        'action' => 'clean_customer_entity_decimal',
                        'query'  => 'TRUNCATE `customer_entity_decimal`;',
                        'after'  => 'ALTER TABLE `customer_entity_decimal` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                10 => array(
                        'action' => 'clean_customer_entity_int',
                        'query'  => 'TRUNCATE `customer_entity_int`;',
                        'after'  => 'ALTER TABLE `customer_entity_int` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                11 => array(
                        'action' => 'clean_customer_entity_text',
                        'query'  => 'TRUNCATE `customer_entity_text`;',
                        'after'  => 'ALTER TABLE `customer_entity_text` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                12 => array(
                        'action' => 'clean_customer_entity_varchar',
                        'query'  => 'TRUNCATE `customer_entity_varchar`;',
                        'after'  => 'ALTER TABLE `customer_entity_varchar` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                13 => array(
                        'action' => 'clean_sales_flat_order',
                        'query'  => 'TRUNCATE `sales_flat_order`;',
                        'after'  => 'ALTER TABLE `sales_flat_order` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                14 => array(
                        'action' => 'clean_sales_flat_order_address',
                        'query'  => 'TRUNCATE `sales_flat_order_address`;',
                        'after'  => 'ALTER TABLE `sales_flat_order_address` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                15 => array(
                        'action' => 'clean_sales_flat_order_grid',
                        'query'  => 'TRUNCATE `sales_flat_order_grid`;',
                        'after'  => 'ALTER TABLE `sales_flat_order_grid` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                16 => array(
                        'action' => 'clean_sales_flat_order_item',
                        'query'  => 'TRUNCATE `sales_flat_order_item`;',
                        'after'  => 'ALTER TABLE `sales_flat_order_item` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                17 => array(
                        'action' => 'clean_sales_flat_order_status_history',
                        'query'  => 'TRUNCATE `sales_flat_order_status_history`;',
                        'after'  => 'ALTER TABLE `sales_flat_order_status_history` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                18 => array(
                        'action' => 'clean_sales_flat_quote',
                        'query'  => 'TRUNCATE `sales_flat_quote`;',
                        'after'  => 'ALTER TABLE `sales_flat_quote` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                19 => array(
                        'action' => 'clean_sales_flat_quote_address',
                        'query'  => 'TRUNCATE `sales_flat_quote_address`;',
                        'after'  => 'ALTER TABLE `sales_flat_quote_address` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                20 => array(
                        'action' => 'clean_sales_flat_quote_address_item',
                        'query'  => 'TRUNCATE `sales_flat_quote_address_item`;',
                        'after'  => 'ALTER TABLE `sales_flat_quote_address_item` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                21 => array(
                        'action' => 'clean_sales_flat_quote_item',
                        'query'  => 'TRUNCATE `sales_flat_quote_item`;',
                        'after'  => 'ALTER TABLE `sales_flat_quote_item` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                22 => array(
                        'action' => 'clean_sales_flat_quote_item_option',
                        'query'  => 'TRUNCATE `sales_flat_quote_item_option`;',
                        'after'  => 'ALTER TABLE `sales_flat_quote_item_option` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                23 => array(
                        'action' => 'clean_sales_flat_order_payment',
                        'query'  => 'TRUNCATE `sales_flat_order_payment`;',
                        'after'  => 'ALTER TABLE `sales_flat_order_payment` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                24 => array(
                        'action' => 'clean_sales_flat_quote_payment',
                        'query'  => 'TRUNCATE `sales_flat_quote_payment`;',
                        'after'  => 'ALTER TABLE `sales_flat_quote_payment` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                25 => array(
                        'action' => 'clean_sales_flat_shipment',
                        'query'  => 'TRUNCATE `sales_flat_shipment`;',
                        'after'  => 'ALTER TABLE `sales_flat_shipment` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                26 => array(
                        'action' => 'clean_sales_flat_shipment_item',
                        'query'  => 'TRUNCATE `sales_flat_shipment_item`;',
                        'after'  => 'ALTER TABLE `sales_flat_shipment_item` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                27 => array(
                        'action' => 'clean_sales_flat_shipment_grid',
                        'query'  => 'TRUNCATE `sales_flat_shipment_grid`;',
                        'after'  => 'ALTER TABLE `sales_flat_shipment_grid` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                28 => array(
                        'action' => 'clean_sales_flat_invoice',
                        'query'  => 'TRUNCATE `sales_flat_invoice`;',
                        'after'  => 'ALTER TABLE `sales_flat_invoice` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                29 => array(
                        'action' => 'clean_sales_flat_invoice_grid',
                        'query'  => 'TRUNCATE `sales_flat_invoice_grid`;',
                        'after'  => 'ALTER TABLE `sales_flat_invoice_grid` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                30 => array(
                        'action' => 'clean_sales_flat_invoice_item',
                        'query'  => 'TRUNCATE `sales_flat_invoice_item`;',
                        'after'  => 'ALTER TABLE `sales_flat_invoice_item` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                31 => array(
                        'action' => 'clean_sendfriend_log',
                        'query'  => 'TRUNCATE `sendfriend_log`;',
                        'after'  => 'ALTER TABLE `sendfriend_log` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                32 => array(
                        'action' => 'clean_tag',
                        'query'  => 'TRUNCATE `tag`;',
                        'after'  => 'ALTER TABLE `tag` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                33 => array(
                        'action' => 'clean_tag_relation',
                        'query'  => 'TRUNCATE `tag_relation`;',
                        'after'  => 'ALTER TABLE `tag_relation` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                34 => array(
                        'action' => 'clean_tag_summary',
                        'query'  => 'TRUNCATE `tag_summary`;',
                        'after'  => 'ALTER TABLE `tag_summary` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                35 => array(
                        'action' => 'clean_wishlist',
                        'query'  => 'TRUNCATE `wishlist`;',
                        'after'  => 'ALTER TABLE `wishlist` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                36 => array(
                        'action' => 'clean_log_quote',
                        'query'  => 'TRUNCATE `log_quote`;',
                        'after'  => 'ALTER TABLE `log_quote` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                37 => array(
                        'action' => 'clean_report_event',
                        'query'  => 'TRUNCATE `report_event`;',
                        'after'  => 'ALTER TABLE `report_event` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
                38 => array(
                        'action' => 'clean_eav_entity_store',
                        'query'  => 'TRUNCATE `eav_entity_store`;',
                        'after'  => 'ALTER TABLE `eav_entity_store` AUTO_INCREMENT=1;',
                        'secure' => TRUE
                ),
        ),
);


/* Liest den Inhalt einer XML-Datei ein und wandelt diesen in ein
 * Mehrdimensiones Array um. Jeder Eintrag bekommt ein
 * Kex=>Value-Paar zugeordnet
 *
 * @param       string      Dateiname der XML
 * @return      array       Fertig geparstes XML-Array
 */
function get_xml_data()
{
	global $config_xml, $data_xml;

	$fp   = fopen($config_xml, "r");
	$data = fread($fp, filesize($config_xml));
	fclose($fp);

	$xml_parser = xml_parser_create();
	xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, 0);
	xml_parse_into_struct($xml_parser, $data, $vals, $index);
	xml_parser_free($xml_parser);

	$params = array();
	$level  = array();

	foreach ( $vals AS $xml_elem )
	{
		if ( $xml_elem['type'] == 'open' )
		{
			if ( array_key_exists('attributes', $xml_elem) )
			{
				list( $level[$xml_elem['level']], $extra ) = array_values( $xml_elem['attributes'] );
			}
			else
			{
				$level[$xml_elem['level']] = $xml_elem['tag'];
			}
		}

		if ($xml_elem['type'] == 'complete')
		{
			$start_level = 1;
			$php_stmt    = '$params';

			while( $start_level < $xml_elem['level'] )
			{
				$php_stmt .= '[$level['.$start_level.']]';
				$start_level++;
			}

			if ( isset($xml_elem['level']) AND isset($xml_elem['tag']) )
			{
				$php_stmt .= '[$xml_elem[\'tag\']] = $xml_elem[\'value\'];';
			}

			eval($php_stmt);
		}
	}

	// DB-Verbindungs-Informationen zurückgeben
	$data_xml = $params['config']['global']['resources']['default_setup']['connection'];
}

/* Verbindung zur Datenbank per PDO herstellen
 *
 * @return      object      Datenbank-Link
 */
function connect()
{
	// http://kushellig.de/prepared-statements-php-data-objects-pdo/
	// http://culttt.com/2012/10/01/roll-your-own-pdo-php-class/

	global $data_xml;

	$host   = $data_xml['host'];
	$dbname = $data_xml['dbname'];
	$dbuser = $data_xml['username'];
	$dbpw   = $data_xml['password'];

	$pdo = null;

	try
	{
		$pdo = new PDO("mysql:host=$host; dbname=$dbname", $dbuser, $dbpw);
		$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		return $pdo;
	}
	catch(PDOException $err)
	{
		return $err -> getMessage();
	}
}

/* SQL-Abfrage an die Datenbank senden um die Felder anzuzeigen
 *
 * @param      string      SQL-Abfrage
 * @return     array       Result der Abfrage
 */
function get_sql($query = '')
{
	$query = trim($query);

	if ( $query == '' )
	{
		$return = 'keine Abfrage!';
	}

	$link = connect();

	if ( is_object($link) )
	{
		// Erfolg => PDO erzeugen und ausf�hren
		$result = $link -> prepare($query);
		$result -> execute();

		return $result -> fetchAll();
	}
	else
	{
		// Fehler zurückgeben
		return $link;
	}
}

/* Wert in der Datenbank ändern
 *
 * @param     string     SQL-Abfrage für das Update
 * @param     string     Feldbezeichner für die Änderung
 * @param     string     Wert für die Änderung
 * @param     bool       Rückgabe der betroffenen Zeilen
 * @return    bool       Erfolgs-Status des Updates
 */
function set_sql($query = '', $param = '', $value = '', $affected = false)
{
	global $last_err;

	$query = trim($query);
	$param = trim($param);
	$value = trim($value);

	if ( ($query == '') OR ($param == '') OR ($value == '') )
	{
		if ( is_null($value) OR !strlen($value) ) {
			$last_err = 'Daten-Wert ist NULL!';
		}
		else {
			$last_err = 'Fehler bei der Daten&uuml;bergabe!';
		}

		return FALSE;
	}

	$link = connect();
	if ( is_object($link) )
	{
		// Erfolg => PDO erzeugen und ausführen
		// http://www.mustbebuilt.co.uk/php/insert-update-and-delete-with-pdo/

		$return = array('error' => FALSE);

		// Damit das leeren auch durchläuft, FK-Check abschalten
		$link -> exec("SET foreign_key_checks=0");

		try {
			$result = $link -> prepare($query);
			$result -> bindParam($param, $value, PDO::PARAM_STR);
			$return['status'] = $result -> execute();
			$return['rows']   = '';
		}
		catch( PDOException $Exception) {
			$last_err = $Exception -> getMessage();
			$return['error']   = $Exception -> getCode();
			$return['message'] = $Exception -> getMessage();

			return $return;
		}

		if ( $affected == true ) {
			$return['rows'] = $result -> rowCount();
		}

		return $return;
	}
	else
	{
		// Fehler zurückgeben
		return $link;
	}
}

function getUserSize($bytes, $precision = 2)
{
	$unit = array(' B',' kB',' MB',' GB',' TB',' PB',' EB',' ZB',' YB');
	for($i = 0; $bytes>= 1024 AND $i < count($unit)-1; $i++) {
		$bytes /= 1024;
	}
	return number_format($bytes, $precision, ",", ".") . $unit[$i];
}

function transformToHtml($string)
{
	return str_replace('_', '-', $string);
}

function extractTableName($query)
{
	$query_structure = explode(' ', strtolower( $query));
	$key_words = array('table', 'update', 'from', 'truncate');
	foreach( $query_structure AS $key => $val ) {
		if ( in_array($val, $key_words) ) {
			return str_replace(array('`', ';'), '', $query_structure[$key + 1]);
		}
	}
}


get_xml_data();

// Alle möglichen AJAX-Funktionen
if ( isset($_POST['action']) ) {
	$return = array('html' => '', 'tables' => array());

	// listet die Eigenschaften der gewählten Aktion auf
	if ( $_POST['action'] == 'getActionProbertys' ) {
		if ( array_key_exists($_POST['what'], $sql) ) {
			$return['tables']['count'] = count($sql[$_POST['what']]);
			$return['tables']['first'] = 1;
			$return['tables']['init']  = transformToHtml($sql[$_POST['what']][1]['action']);

			foreach( $sql[$_POST['what']] AS $key => $val) {
				$return['tables']['action'][] = array(
													'name' => transformToHtml($val['action']),
													'title' => $val['action']
												);
			}
		}
		elseif ( $_POST['what'] == 'clearAllTables' ) {
			$tables = get_sql('SHOW TABLES FROM ' . $data_xml['dbname']);
			$return['tables']['count'] = count($tables);
			$return['tables']['first'] = 1;
			$return['tables']['init']  = transformToHtml($tables[0][0]);

			foreach( $tables AS $key => $table) {
				$return['tables']['action'][] = array(
													'name'  => transformToHtml($table[0]),
													'title' => $table[0]
												);
			}
		}
		else {
			$return['tables']['count'] = 0;
			$return['tables']['first'] = 0;
			$return['tables']['action'][] = array(
					'name'  => 'empty',
					'title' => 'Unbekannte Aktion |' . $_POST['what'] . '|'
			);
		}
	}

	// Aktion ausführen
    if ( $_POST['action'] == 'runAction' ) {
    	$position = intval($_POST['start']);
    	$action   = trim($_POST['what']);
    	$next     = $position + 1;

    	if ( array_key_exists($_POST['what'], $sql) ) {
    		if ( ( $position > 0 ) AND ( $position <= count($sql[$_POST['what']]) ) ) {
    			$query = $sql[$_POST['what']][$position]['query'];
    			$key   = $sql[$_POST['what']][$position]['action'];
    			$table = extractTableName($query);

    			if ( ( $resticted_host === FALSE ) OR ($_POST['what'] == 'deleteLog') ) {
                    if ( array_key_exists('secure', $sql[$_POST['what']][$position]) ) {
                        set_sql('SET FOREIGN_KEY_CHECKS=0;', 1, 1, true);
                    }

    				// Aktionen ausführen
    				$err = set_sql($query, 1, 1, true);

                    if ( array_key_exists('after', $sql[$_POST['what']][$position]) ) {
                        $err1 = set_sql($sql[$_POST['what']][$position]['after'], 1, 1, true);
                    }

                    if ( array_key_exists('secure', $sql[$_POST['what']][$position]) ) {
                        set_sql('SET FOREIGN_KEY_CHECKS=1;', 1, 1, true);
                    }
    			}
    			else {
    				// Aktion blockieren weil produktive Systeme
    				$err['error']   = true;
    				$err['message'] = 'Restricted Host!!';
    			}

    			$new  = get_sql("SHOW TABLE STATUS WHERE name = '" . $table . "'");

    			$return['html']   = ( ($err['error'] == FALSE) ? 'Affected: ' . $err['rows'] : $err['message']);
    			$return['tables'] = array(
					    				'error' => ( ($err['error'] == FALSE) ? 'okay' : 'fail' ),
    									'code'  => ( ($err['error'] == FALSE) ? 1      : $err['error']),
					    				'field' => transformToHtml($key),
					    				'table' => transformToHtml($table),
					    				'next'  => $next,
					    				'rows'  => intval($new[0]['Rows']),
    									'size'  => getUserSize($new[0]['Data_length']),
					   					'init'  => ( ($next <= count($sql[$_POST['what']])) ? transformToHtml($sql[$_POST['what']][$next]['action']) : '' )
					    			);

                if ( is_array($err1) ) {
                    $return['html'] .= ( ($err1['error'] == FALSE) ? '; Affected: ' . $err1['rows'] : $err1['message']);
                    $return['tables']['error'] = ( ($err1['error'] == FALSE) ? 'okay' : 'fail' );
                    $return['tables']['code']  = ( ($err1['error'] == FALSE) ? 1      : $err1['error']);
                }

    		}
    		else {
    			// hier stimmt was nicht!
    			$return['html']           = 'Position nicht gefunden: ' . $position;
    			$return['tables']['code'] = -1;
    		}
    	}
    	elseif ( $_POST['what'] == 'clearAllTables' ) {
    		// Alle Tabellen bearbeiten
    		$tableName = htmlentities(trim($_POST['act']), ENT_QUOTES, "UTF-8");

    		if ( $resticted_host === FALSE ) {
    			// Aktionen ausführen
    			$err = set_sql('DROP TABLE IF EXISTS ' . $tableName, 1, 1);
    		}
    		else {
    			// Aktion blockieren weil produktive Systeme
    			$err['error']   = true;
    			$err['message'] = 'Restricted Host!!';
    		}

    		$return['html'] = ( ($err['error'] == FALSE) ? 'Return-Code: ' . $err['status'] : $err['message']);
    		$return['tables'] = array(
    								'error' => ( ($err['error'] == FALSE) ? 'okay' : 'fail' ),
    								'code'  => ( ($err['error'] == FALSE) ? 1      : $err['error']),
					    			'field' => transformToHtml($_POST['act']),
					    			'table' => transformToHtml($_POST['act']),
					    			'next'  => $next,
    								'rows'  => ( ($err['error'] == FALSE) ? 'gelöscht' : 'Fehler!'),
    								'size'  => ( ($err['error'] == FALSE) ? 0          : -99),
					    			'init'  => transformToHtml($_POST['sec']),
					    		);
    	}
    	else {
    		// was wird das??
    		$return['html']           = 'Aktion nicht vorhanden: ' . $_POST['what'];
    		$return['tables']['code'] = -1;
    	}
    }

    echo json_encode($return);

	exit;
}


echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">
    <head>
        <title>Magento - DB-Tool</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.15/css/theme.default.min.css" />
        <style type="text/css">
            html            {background-color:#DCDCDC; width:800px; margin: 0 auto;}
            table           {margin:20px 0px 20px 20px; width:100%;}
            input           {width:300px;}
            hr              {width:500px;}
            .result         {display:inline; float:right; margin-right:50px;}
            .okay           {color:#008000;}
            .fail           {background-color:#FF0000 !important; color:#FFFFFF !important; font-weight:bold;}
            .change td      {background-color:#9FB6CD;}
            .copy           {font-size:9px;}
            #status-msg     {display:block; margin:10px 0; width:98.5%; border:1px solid #000; padding:5px; background-color:#FFF; overflow-y:scroll; height:100px;}
            .status-div     {display:inline-block;}
            button          {width:14.4%; padding:10px; margin:10px 25px; cursor:pointer;}
            button:first-child {margin-left: 0;}
            button:last-child  {margin-right: 0;}
            button:disabled {cursor:no-drop;}
			.alert          {background-color: #ff0000; color: #ffffff;}
            .start          {background-color: #008000; color: #ffffff;}
        </style>
        <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.15/js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.15/js/parsers/parser-metric.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
        <script type="text/javascript">
            var action     = "empty";   // auszuführende Aktion
            var action_cnt = 0;         // Anzahl der Aktionen
            var action_pos = 0;         // kommende Aktions-Nummer
            var action_ok  = false;     // für Abfrage beim ClearTable

            var first_spinner = "";

            $(document).ready(function(){
                $("#database-table").tablesorter({
                    usNumberFormat : false
                });
                // damit keiner Blödsinn macht :)
                $("#action-start").prop("disabled", true);
            });

			function resetForAction(outClear) {
                action     = "empty";
                action_cnt = 0;
                action_pos = 0;
                action_ok  = false;

                first_spinner = "";

                $("#action-start").removeClass("start").prop("disabled", true);
                if (outClear == true) {
                     $("#database-table tr").removeClass("change");
                     $("#status-msg").html("");
                }
			}

            function getTableData(index) {
                return $("#status-msg div[data-id=\'" + index + "\']").attr("data-table");
            }

			function setAction(whatAction) {
                $.ajax({
                    url   : "' . $script . '",
                    method: "POST",
                    data  : {
                        "action": "getActionProbertys",
                        "what"  : whatAction
                    },
					beforeSend: function() {
						resetForAction(true);
					}
                })
                .done(function(data) {
                    var s = jQuery.parseJSON(data);
                    action     = whatAction;
                    action_cnt = s.tables.count;
                    action_pos = s.tables.first;
                    $.each(s.tables.action, function(index, value){
                        $("#status-msg").append(
                                             "<div id=\"action-" + value.name + "\" data-id=\"" + (index + 1) + "\" data-table=\"" + value.title + "\">" +
                                             (index + 1) + ".) Action: " + value.title +
                                             " <span id=\"status-" + value.name + "\" class=\"result\"><span>" +
                                             "</div>"
                                         );
                    });
                    first_spinner = "status-" + s.tables.init;

                    if (action == "clearAllTables") {
                        action_ok = false;
                    }
                    else {
                        action_ok = true;
                    }

                    $("#status-msg").scrollTo("#action-" + s.tables.init);
                    $("#action-start").addClass("start").removeAttr("disabled");
                })
                .fail(function(jqXHR, textStatus) {
                    alert( "Request failed: " + textStatus );
                });
            }

            function startAction() {
                if (action != "empty") {
                    if ( action_cnt >= 1 && action_pos <= action_cnt ) {
                        if (action == "clearAllTables" && action_ok == false) {
                            // Initiale Frage, ob wirklich alle Tabellen gelöscht werden sollen
                            if (confirm("Sollen alle Tabelle gelöscht werden?\n\nDiese Aktion kann nicht rückgängig gemacht werden!")) {
                                action_ok = true;
                            }
                            else {
                                resetForAction(true);
                                return false;
                            }
                        }

                        setTimeout(function() {
	                        $.ajax({
			                    url   : "' . $script . '",
			                    method: "POST",
			                    data  : {
                                    "action": "runAction",
                                    "what"  : action,
                                    "start" : action_pos,
                                    "act"   : getTableData(action_pos),      // nur für ClearAll
                                    "sec"   : getTableData(action_pos + 1),  // nur für ClearAll
                                },
								beforeSend: function() {
                                    $("#" + first_spinner).html("<img src=\"http://loadinggif.com/images/image-selection/22.gif\" />");
								}
	                        })
	                        .done(function(data){
                                var s = jQuery.parseJSON(data);

                                action_pos    = s.tables.next;
                                first_spinner = "status-" + s.tables.init;

                                $("#status-msg").scrollTo("#action-" + s.tables.field);
                                $("#status-" + s.tables.field).html( s.html ).addClass( s.tables.error );
                                $("#row-"    + s.tables.table).addClass("change");
                                $("#rows-"   + s.tables.table).html( s.tables.rows );
                                $("#size-"   + s.tables.table).html( s.tables.size );

                                if (action_pos > action_cnt || s.tables.error == -1) {
                                    resetForAction(false);
                                    return false;
                                }
                                else {
                                    //return false;
                                    startAction();
                                }
	                        })
			                .fail(function(jqXHR, textStatus) {
			                    alert( "Request failed: " + textStatus );
                                return false;
			                });
                        }, 100);
                    }
                    else {
                        alert( "Fehler!\n\n" + action_pos + ":" + action_cnt );
                    }
                }
                else {
                    alert("unbekannte Aktion: " + action);
                }
            }
        </script>
    </head>
    <body>
        <h3>Server: ' . $_SERVER['SERVER_NAME']. ' <i>(' . $data_xml['dbname']. ')</i></h3>
        <div id="status-msg"></div>
        <div id="aktionen">
            <button onclick="setAction(\'cleanCustomer\');"' . ( ($resticted_host === TRUE) ? ' disabled="disabled"' : ' class="alert"' ) . '>Kunden &amp; Best. l&ouml;schen</button>
            <button onclick="setAction(\'anonUser\');"' . ( ($resticted_host === TRUE) ? ' disabled="disabled"' : '' ) . '>Kundendaten anonymisieren</button>
            <button onclick="setAction(\'deleteLog\');">LOG-Tabellen leeren</button>
            <button onclick="setAction(\'clearAllTables\');"' . ( ($resticted_host === TRUE) ? ' disabled="disabled"' : ' class="alert"' ) . '>alle Tabellen l&ouml;schen</button>
            <button onclick="startAction();" id="action-start" class="">Aktion durchf&uuml;hren</button>
        </div>
';

$data = get_sql('SHOW TABLE STATUS');

if ( count($data) AND is_array($data) ) {
	echo '
        <table id="database-table" class="tablesorter">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tabelle</th>
                    <th>Datens&auml;tze</th>
                    <th class="sorter-metric" data-metric-name-full="byte|Byte|BYTE" data-metric-name-abbr="b|B">Gr&ouml;&szlig;e</th>
                </tr>
            </thead>
            <tbody>
';
	foreach( $data AS $key => $table ) {
		$id_name = transformToHtml($table['Name']);

		echo '
                <tr id="row-' . $id_name . '">
                    <td>' . ($key + 1) . '</td>
                    <td>' . $table['Name'] . '</td>
                    <td id="rows-' . $id_name . '">' . $table['Rows'] . '</td>
                    <td id="size-' . $id_name . '">' . getUserSize($table['Data_length']). '</td>
                </tr>';
	}
    echo '
            </tbody>
        </table>
';
}
else {
	echo '<script type="text/javascript">
$(document).ready(function(){
    // damit keiner Blödsinn macht :)
    $("#aktionen button").each(function(){
        $(this).prop("disabled", true);
    });
});
</script>
';
}


echo '
        <div class="copy">&copy; 2017 by B3-IT System GmbH</div>
    </body>
</html>
';
?>
