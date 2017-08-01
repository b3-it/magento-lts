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

/////////////////////// Letzte Fehlermeldung \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
$last_err = null;

/////////////////////// SQL-Abfragen \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
$sql = array(
		'deleteLog' => array(
				1  => array(
						'action' => 'log_customer',
						'query'  => 'DELETE IGNORE FROM `log_customer`;'
				),
				2  => array(
						'action' => 'log_quote',
						'query'  => 'DELETE IGNORE FROM `log_quote`;'
				),
				3  => array(
						'action' => 'log_summary',
						'query'  => 'DELETE IGNORE FROM `log_summary`;'
				),
				4  => array(
						'action' => 'log_summary_type',
						'query'  => 'DELETE IGNORE FROM `log_summary_type`;'
				),
				5  => array(
						'action' => 'log_url',
						'query'  => 'DELETE IGNORE FROM `log_url`;'
				),
				6  => array(
						'action' => 'log_url_info',
						'query'  => 'DELETE IGNORE FROM `log_url_info`;'
				),
				7  => array(
						'action' => 'log_visitor',
						'query'  => 'DELETE IGNORE FROM `log_visitor`;'
				),
				8  => array(
						'action' => 'log_visitor_info',
						'query'  => 'DELETE IGNORE FROM `log_visitor_info`;'
				),
				9  => array(
						'action' => 'log_visitor_online',
						'query'  => 'DELETE IGNORE FROM `log_visitor_online`;'
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
						'action' => 'anon_sales_email_order',
						'query'  => "UPDATE `sales_flat_order` SET `customer_email` = CONCAT('anon_',customer_id,'@testshop.org') WHERE `customer_email` NOT LIKE '%testshop.org' OR `customer_email` NOT LIKE '%trw-net.de' OR `customer_email` NOT LIKE '%hempelfernsehen.de';"
				),
				6  => array(
						'action' => 'anon_sales_addess_quote',
						'query'  => "UPDATE `sales_flat_quote_address` SET `firstname` = CONCAT('firstname_',customer_id), `lastname` = CONCAT('lastname_',customer_id), `company` = CONCAT('company_',customer_id), `company2` = CONCAT('company2_',customer_id) , `company3` = CONCAT('company3_',customer_id) ;"
				),
				7  => array(
						'action' => 'anon_sales_addess_order',
						'query'  => "UPDATE `sales_flat_order_address` SET `firstname` = CONCAT('firstname_',customer_id), `lastname` = CONCAT('lastname_',customer_id), `company` = CONCAT('company_',customer_id), `company2` = CONCAT('company2_',customer_id) , `company3` = CONCAT('company3_',customer_id) ;"
				),
				8  => array(
						'action' => 'anon_cusomer_firstname',
						'query'  => "UPDATE `customer_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'firstname' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer' SET `value` = CONCAT('firstname_',entity_id);"
				),
				9  => array(
						'action' => 'anon_cusomer_lastname',
						'query'  => "UPDATE `customer_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'lastname' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer' SET `value` = CONCAT('lastname_',entity_id);"
				),
				10 => array(
						'action' => 'anon_cusomer_company',
						'query'  => "UPDATE `customer_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer' SET `value` = CONCAT('company_',entity_id);"
				),
				11 => array(
						'action' => 'anon_cusomer_company2',
						'query'  => "UPDATE `customer_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company2' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer' SET `value` = CONCAT('company2_',entity_id);"
				),
				12 => array(
						'action' => 'anon_cusomer_company3',
						'query'  => "UPDATE `customer_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company3' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer' SET `value` = CONCAT('company3_',entity_id);"
				),
				13 => array(
						'action' => 'anon_address_firstname',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'firstname' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('firstname_',entity_id);"
				),
				14 => array(
						'action' => 'anon_address_lastname',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'lastname' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('lastname_',entity_id);"
				),
				15 => array(
						'action' => 'anon_address_company',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('company_',entity_id);"
				),
				16 => array(
						'action' => 'anon_address_company2',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company2' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('company2_',entity_id);"
				),
				17 => array(
						'action' => 'anon_address_company3',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'company3' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('company3_',entity_id);"
				),
				18 => array(
						'action' => 'anon_address_phone',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'telephone' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = '';"
				),
				19 => array(
						'action' => 'anon_address_street',
						'query'  => "UPDATE `customer_address_entity_text` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'street' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('Teststraße ',entity_id);"
				),
				20 => array(
						'action' => 'anon_address_city',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'city' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = 'Testort';"
				),
				21 => array(
						'action' => 'anon_address_postcode',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'postcode' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT(entity_id);"
				),
				22 => array(
						'action' => 'anon_address_email',
						'query'  => "UPDATE `customer_address_entity_varchar` AS `adr` JOIN `eav_attribute` AS `att` ON `att`.`attribute_id` = `adr`.`attribute_id` AND `att`.`attribute_code` = 'email' JOIN `eav_entity_type` AS `et` ON `et`.`entity_type_id` = `att`.`entity_type_id` AND `et`.`entity_type_code` = 'customer_address' SET `value` = CONCAT('anon_',entity_id,'@testshop.org') WHERE `value` NOT LIKE '%testshop.org' OR `value` NOT LIKE '%trw-net.de' OR `value` NOT LIKE '%hempelfernsehen.de';"
				),
				23 => array(
						'action' => 'anon_billing_invoice_grid',
						'query'  => "UPDATE `sales_flat_invoice_grid` SET `billing_name` = CONCAT('billing_name',increment_id), billing_company = CONCAT('billing_company',increment_id);"
				),
				24 => array(
						'action' => 'anon_billing_order_grid',
						'query'  => "UPDATE `sales_flat_order_grid` SET `billing_name` = CONCAT('billing_name',increment_id), billing_company = CONCAT('billing_company',increment_id), shipping_name = CONCAT('shipping_name',increment_id),  shipping_company = CONCAT('shipping_company',increment_id);"
				),
				25 => array(
						'action' => 'anon_delete_newsletter',
						'query'  => "DELETE IGNORE FROM `newsletter_subscriber`;"
				),
				26 => array(
						'action' => 'anon_delete_email_queue',
						'query'  => "DELETE IGNORE FROM `core_email_queue`;"
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
		if ( is_null($value) OR !strlen($value) )
		{
			$last_err = 'Daten-Wert ist NULL!';
		}
		else
		{
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

function getUserSize($bytes)
{
	$bytes = max(0, $bytes);
	
	foreach (array(' B',' KB',' MB',' GB',' TB',' PB') AS $i => $k)
	{
		if ($bytes < 1024) break;
		$bytes /= 1024;
	}
	return number_format($bytes, 2, ",", ".") . $k;
}

function transformToHtml($string)
{
	return str_replace('_', '-', $string);
}

function extractTableName($query)
{
	$query_structure = explode(' ', strtolower( $query));
	$key_words = array('table', 'update', 'from');
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

    			// Aktionen ausführen
    			$err  = set_sql($query, 1, 1, true);
    			$new  = get_sql("SHOW TABLE STATUS WHERE name = '" . $table . "'");

				$return['html']   = ( ($err['error'] == FALSE) ? 'Affected: ' . $err['rows'] : $err['message']);
    			$return['tables'] = array(
					    				'error' => ( ($err['error'] == FALSE) ? 'okay' : 'fail' ),
    									'code'  => ( ($err['error'] == FALSE) ? 1      : $err['error']),
					    				'field' => transformToHtml($key),
					    				'table' => transformToHtml($table),
					    				'next'  => $next,
					    				'rows'  => intval($new['Rows']),
					    				'size'  => getUserSize($new['Data_length']),
					   					'init'  => ( ($next <= count($sql[$_POST['what']])) ? transformToHtml($sql[$_POST['what']][$next]['action']) : '' )
					    			);
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
    		$err = set_sql('DROP TABLE IF EXISTS ' . $tableName, 1, 1);
    		
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
            html       {background-color:#DCDCDC; width:750px; margin: 0 auto;}
            table      {margin:20px 0px 20px 20px; width:100%;}
            input      {width:300px;}
            hr         {width:500px;}
            .okay      {color:#008000;}
            .fail      {background-color:#FF0000 !important; color:#FFFFFF !important; font-weight:bold;}
            .change td {background-color:#9FB6CD;}
            .copy      {font-size:9px;}
            #status-msg{display:block; margin:10px 0; width:98.5%; border:1px solid #000; padding:5px; background-color:#FFF; overflow-y:scroll; height:100px;}
            .status-div{display:inline-block;}
            button     {width:17.5%; padding:10px; margin:10px 25px; cursor:pointer;}
			.alert     {background-color: #ff0000; color: #ffffff;}
            .start     {background-color: #008000; color: #ffffff;}
        </style>
        <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.15/js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
        <script type="text/javascript">
            var action     = "empty";   // auszuführende Aktion
            var action_cnt = 0;         // Anzahl der Aktionen
            var action_pos = 0;         // kommende Aktions-Nummer
            var action_ok  = false;     // für Abfrage beim ClearTable

            var first_spinner = "";

            $(document).ready(function(){
                $("#database-table").tablesorter();
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
                    data  : {"action": "getActionProbertys", "what" : whatAction},
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
                                             " <span id=\"status-" + value.name + "\" class=\"\"><span>" +
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
                                $("#rows-"   + s.tables.table).html( parseInt(s.tables.rows) );
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
        <div id="status-msg"></div>
        <div id="aktionen">
            <button onclick="setAction(\'anonUser\');">Kundendaten anonymisieren</button>
            <button onclick="setAction(\'deleteLog\');">LOG-Tabellen leeren</button>
            <button onclick="setAction(\'clearAllTables\');" class="alert">alle Tabellen löschen</button>
            <button onclick="startAction();" id="action-start" class="">Aktion durchführen</button>
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
                    <th>Gr&ouml;&szlig;e</th>
                </tr>
            </thead>
            </tbody>
';
	foreach( $data AS $key => $table ) {
		$id_name = transformToHtml($table['Name']);

		echo '
                <tr id="row-' . $id_name . '">
                    <td>' . ($key + 1) . '</td>
                    <td>' . $table['Name'] . '</td>
                    <td id="rows-' . $id_name . '">' . $table['Rows'] . '</td>
                    <td id="size-' . $id_name . '">' . getUserSize($table['Data_length']) . '</td>
                </tr>';
	}
    echo '
            </tbody>
        </table>
';
}



echo '
        <div class="copy">&copy; 2017 by B3-IT System GmbH</div>
    </body>
</html>
';
?>