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
				'log_customer'       => 'DELETE FROM `log_customer`',
				'log_quote'          => 'DELETE FROM `log_quote`',
				'log_summary'        => 'DELETE FROM `log_summary`',
				'log_summary_type'   => 'DELETE FROM `log_summary_type`',
				'log_url'            => 'DELETE FROM `log_url`',
				'log_url_info'       => 'DELETE FROM `log_url_info`',
				'log_visitor'        => 'DELETE FROM `log_visitor`',
				'log_visitor_info'   => 'DELETE FROM `log_visitor_info`',
				'log_visitor_online' => 'DELETE FROM `log_visitor_online`',
		),
		'anonUser' => array(
		        'anon_customer_create'      => 'ALTER TABLE `customer_entity` CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT 0;',
				'anon_customer_update'      => 'ALTER TABLE `customer_entity` CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT 0;',
				'anon_customer_email'       => "UPDATE customer_entity SET email = concat('anon_',entity_id,'@testshop.org') WHERE email NOT LIKE '%testshop.org' OR email NOT LIKE '%trw-net.de' OR email NOT LIKE '%hempelfernsehen.de';",
				'anon_sales_email_quote'    => "UPDATE sales_flat_quote SET customer_email = concat('anon_',customer_id,'@testshop.org') WHERE customer_email NOT LIKE '%testshop.org' OR customer_email NOT LIKE '%trw-net.de' OR customer_email NOT LIKE '%hempelfernsehen.de';",
				'anon_sales_email_order'    => "UPDATE sales_flat_order SET customer_email = concat('anon_',customer_id,'@testshop.org') WHERE customer_email NOT LIKE '%testshop.org' OR customer_email NOT LIKE '%trw-net.de' OR customer_email NOT LIKE '%hempelfernsehen.de';",
				'anon_sales_addess_quote'   => "UPDATE sales_flat_quote_address SET firstname = concat('firstname_',customer_id), lastname = concat('lastname_',customer_id), company = concat('company_',customer_id),  company2 = concat('company2_',customer_id) , company3 = concat('company3_',customer_id) ;",
				'anon_sales_addess_order'   => "UPDATE sales_flat_order_address SET firstname = concat('firstname_',customer_id), lastname = concat('lastname_',customer_id), company = concat('company_',customer_id),  company2 = concat('company2_',customer_id) , company3 = concat('company3_',customer_id) ;",
				'anon_cusomer_firstname'    => "UPDATE customer_entity_varchar AS adr join eav_attribute AS att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'firstname' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer' set value = concat('firstname_',entity_id);",
				'anon_cusomer_lastname'     => "UPDATE customer_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'lastname' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer' set value = concat('lastname_',entity_id);",
				'anon_cusomer_company'      => "UPDATE customer_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'company' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer' set value = concat('company_',entity_id);",
				'anon_cusomer_company2'     => "UPDATE customer_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'company2' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer' set value = concat('company2_',entity_id);",
				'anon_cusomer_company3'     => "UPDATE customer_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'company3' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer' set value = concat('company3_',entity_id);",
				'anon_address_firstname'    => "UPDATE customer_address_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'firstname' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer_address' set value = concat('firstname_',entity_id);",
				'anon_address_lastname'     => "UPDATE customer_address_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'lastname' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer_address' set value = concat('lastname_',entity_id);",
				'anon_address_company'      => "UPDATE customer_address_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'company' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer_address' set value = concat('company_',entity_id);",
				'anon_address_company2'     => "UPDATE customer_address_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'company2' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer_address' set value = concat('company2_',entity_id);",
				'anon_address_company3'     => "UPDATE customer_address_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'company3' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer_address' set value = concat('company3_',entity_id);",
				'anon_address_phone'        => "UPDATE customer_address_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'telephone' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer_address' set value = '';",
				'anon_address_street'       => "UPDATE customer_address_entity_text as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'street' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer_address' set value = concat('Teststraße ',entity_id);",
				'anon_address_city'         => "UPDATE customer_address_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'city' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer_address' set value = 'Testort';",
				'anon_address_postcode'     => "UPDATE customer_address_entity_varchar as adr join eav_attribute as att on att.attribute_id = adr.attribute_id AND att.attribute_code = 'postcode' join eav_entity_type as et on et.entity_type_id = att.entity_type_id AND et.entity_type_code = 'customer_address' set value = concat(entity_id);",
				'anon_billing_invoice_grid' => "UPDATE sales_flat_invoice_grid set billing_name = concat('billing_name',increment_id), billing_company = concat('billing_company',increment_id);",
				'anon_billing_order_grid'   => "UPDATE sales_flat_order_grid set billing_name = concat('billing_name',increment_id), billing_company = concat('billing_company',increment_id), shipping_name = concat('shipping_name',increment_id),  shipping_company = concat('shipping_company',increment_id);",
				'anon_newsletter'           => "DELETE FROM `newsletter_subscriber`;",
				'anon_email_queue'          => "DELETE FROM `core_email_queue`;",
		)
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
	
	// DB-Verbindungs-Informationen zur�ckgeben
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
		
		// Damit das leeren auch durchläuft, FK-Check abschalten
		$link -> exec("SET foreign_key_checks=0");
		
		$result = $link -> prepare($query);
		$result -> bindParam($param, $value, PDO::PARAM_STR);
		$status = $result -> execute();
		$count  = $result -> rowCount();
		
		if ( $affected == true ) {
			
			return array('status' => $status, 'rows' => $count);
		}
		else {
			return $status;
		}
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
	
	if ( $_POST['action'] == 'clearLogTables') {
		foreach( $sql['deleteLog'] AS $table => $query ) {
			$err = set_sql($query, 1, 1);
			$return['html'] .= '<div class="' . ( ($err == TRUE) ? 'okay' : 'fail' ) . '">' .
					           date('d.m.y H:i:s') .
			                   ' [Code: ' . ( ($err == TRUE) ? $err : $last_err) . '] Action: ' . $table .
			                   '</div>';
			$new = get_sql("SHOW TABLE STATUS WHERE name = '" . $table . "'");
			$return['tables'][] = array(
									'name' => transformToHtml($table),
									'rows' => intval($new['Rows']),
									'size' => getUserSize($new['Data_length'])
								  );
		}
	}
	
	if ( $_POST['action'] == 'anonUserData' ) {
		foreach( $sql['anonUser'] AS $key => $query ) {
			$table = extractTableName($query);
			$err = set_sql($query, 1, 1, true);

			$return['html'] .= '<div class="' . ( ($err['status'] == TRUE) ? 'okay' : 'fail' ) . '">' .
					           date('d.m.y H:i:s') .
			                   ' [Code: ' . ( ($err['status'] == TRUE) ? $err['status'] : $last_err) . '] Action: ' . $table .
			                   ' / Affected: ' . $err['rows'] . '</div>';
			$return['tables'][] = array(
									'name' => transformToHtml($table),
									'rows' => intval($err['rows'])
								  );
		}
	}
	
	if ( $_POST['action'] == 'clearAllTables' ) {
		$tables = get_sql('SHOW TABLES FROM ' . $data_xml['dbname']);
		foreach( $tables AS $key => $data ) {
			$tableName = $data[0];
			$err = set_sql('DROP TABLE IF EXISTS ' . $tableName, 1, 1);

			$return['html'] .= '<div class="' . ( ($err == TRUE) ? 'okay' : 'fail' ) . '">' .
					           date('d.m.y H:i:s') .
			                   ' [Code: ' . ( ($err == TRUE) ? $err : $last_err) . '] Action: ' . $tableName .
			                   '</div>';			
			$return['tables'][] = array(
									'name'  => transformToHtml($tableName),
									'stat'  => ( ($err == TRUE) ? 1 : 0),
									'error' => $last_err
								  );
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
            button     {width:26%; padding:10px; margin:10px 25px;}
			.alert     {background-color: #ff0000; color: #ffffff;}
        </style>
        <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.15/js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("#database-table").tablesorter();
            });
			
			function resetForAction() {
				$("#database-table tr").removeClass("change");
				$("#status-msg").html("");
			}
			
            function clearLog() {
                $.ajax({
                    url   : "' . $script . '",
                    method: "POST",
                    data  : {"action": "clearLogTables"},
					beforeSend: function() {
						resetForAction();
					}
                })
                .done(function(data) {
                    var s = jQuery.parseJSON(data);
                    $("#status-msg").append(s.html);
                    $.each(s.tables, function(index, value){
                        $("#row-"  + value.name).addClass("change");
                        $("#rows-" + value.name).html( parseInt(value.rows) );
                        $("#size-" + value.name).html( value.size );
                    });
                })
                .fail(function(jqXHR, textStatus) {
                    alert( "Request failed: " + textStatus );
                });
            }
            function anonUser() {
				$.ajax({
                    url   : "' . $script . '",
                    method: "POST",
                    data  : {"action": "anonUserData"},
					beforeSend: function() {
						resetForAction();
					}
				})
                .done(function(data) {
					var s = jQuery.parseJSON(data);
                    $("#status-msg").append(s.html);
					$.each(s.tables, function(index, value){
						$("#row-"  + value.name).addClass("change");
					});
				})
                .fail(function(jqXHR, textStatus) {
                    alert( "Request failed: " + textStatus );
                });
			}
            function clearAllTables() {
				if (confirm("Sollen alle Tabelle geleert werden?\n\nDiese Aktion kann nicht rückgängig gemacht werden!")) {
					$.ajax({
                    url   : "' . $script . '",
                    method: "POST",
                    data  : {"action": "clearAllTables"},
						beforeSend: function() {
							resetForAction();
						}
					})
					.done(function(data) {
						var s = jQuery.parseJSON(data);
                        $("#status-msg").append(s.html);
						$.each(s.tables, function(index, value){
							$("#row-"  + value.name).addClass("change");
							if(value.stat == 1) {
								$("#rows-" + value.name).html("<span class=\"okay\">Ok</span>");
								$("#size-" + value.name).html("--");
							}
							else {
								$("#row-" + value.name).removeClass("change");
								$("#rows-" + value.name).html(value.error).addClass("fail");
								$("#size-" + value.name).html("");
							}
						});
					})
					.fail(function(jqXHR, textStatus) {
						alert( "Request failed: " + textStatus );
					});
				}
			}
        </script>
    </head>
    <body>
        <div id="status-msg"></div>
        <div id="aktionen">
            <button onclick="anonUser();">Kundendaten anonymisieren</button>
            <button onclick="clearLog();">LOG-Tabellen leeren</button>
            <button onclick="clearAllTables();" class="alert">alle Tabellen leeren</button>
        </div>
';

$data = get_sql('SHOW TABLE STATUS');
//var_dump($data);
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
                    <td>' . $key . '</td>
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