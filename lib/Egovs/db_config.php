<?php
error_reporting( E_ALL ^ E_NOTICE );

$ds         = DIRECTORY_SEPARATOR;  // System-Seperator verwenden
$sub[]      = $ds . join($ds, array('lib', 'egovs'));
$sub[]      = $ds . join($ds, array('lib', 'Egovs'));
$base       = str_replace( $sub, '', dirname(__FILE__) );
$config_xml = $base . $ds . join($ds, array('app', 'etc', 'local.xml'));
$data_xml   = array();

/////////////////////// Konfiguration der Abfrage \\\\\\\\\\\\\\\\\\\\\\\\\\\
$sql_table  = 'core_config_data';
$sql_fields = array(
                  "path LIKE 'web/%/base_url'",
                  "path LIKE 'web/cookie/cookie_%'",
                  "path LIKE 'admin/security/session_cookie%'"
              );


/* Liest den Inahlt einer XML-Datei ein und wandelt diesen in ein
 * Mehrdimensiones Array um. Jeder Eintrag bekommt ein
 * Kex=>Value-Paar zugeordnet
 *
 * @param       string      Dateiname der XML
 *
 * return       array       Fertig geparstes XML-Array
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
        // Erfolg => PDO erzeugen und ausführen
        $result = $link -> prepare($query);
        $result -> execute();

        $data = array();
        return $result -> fetchAll();
    }
    else
    {
        // Fehler zurückgeben
        return $link;
    }
}

function set_sql($query = '', $param = '', $value = '')
{
    $query = trim($query);
    $param = trim($param);
    $value = trim($value);

    if ( ($query == '') OR ($param == '') OR ($value == '') )
    {
        return 'Fehler bei der Daten&uuml;bergabe!';
    }

    $link = connect();
    if ( is_object($link) )
    {
        // Erfolg => PDO erzeugen und ausführen
        // http://www.mustbebuilt.co.uk/php/insert-update-and-delete-with-pdo/

        $result = $link -> prepare($query);
        $result -> bindParam($param, $value, PDO::PARAM_STR);

        return $result -> execute();
    }
    else
    {
        // Fehler zurückgeben
        return $link;
    }
}




echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">
    <head>
        <title>Magento - DB-Config</title>
        <style type="text/css">
            html  {background-color:#DCDCDC;}
            table {width:650px; margin:20px 0px 20px 20px;}
            input {width:300px;}
            hr    {width:500px;}
            .okay {color:#008000;}
            .fail {background-color:#FF0000; color:#FFFFFF; font-weight:bold;}
            .copy {font-size:9px;}
        </style>
    </head>
    <body>
';

get_xml_data();

if ( isset($_POST['a']) AND ($_POST['a'] == 'update') )
{
    $sql_data = array();
    foreach( $_POST AS $key => $val )
    {
        if ( $key != 'a' )
        {
            $err = set_sql("UPDATE " . $sql_table . " SET value='" . $val . "' WHERE path='" . $key . "'", $key, $val);

            $sql_data[] = '<div class="' . ( ($err == TRUE) ? 'okay' : 'fail' ) . '">[Code: ' . $err . '] ' . $key . '</div>';
        }
    }

    echo implode("\n", $sql_data);
}

$data = get_sql("SELECT path, value FROM " . $sql_table . " WHERE " . implode(' OR ', $sql_fields));

echo "<form action=\"" . $_SERVER['PHP_SELF'] . "\" method=\"post\">\n" .
     "<input type=\"hidden\" name=\"a\" value=\"update\" />\n" .
     "<table summary=\"\">\n";
if ( is_array($data) )
{
    foreach( $data AS $key => $val )
    {
        echo "  <tr>\n" .
             "    <td>" . $val['path'] . "</td>\n" .
             "    <td><input type=\"text\" name=\"" . $val['path'] . "\" value=\"" . $val['value'] . "\" /></td>\n" .
             "  </tr>\n";
    }
    echo "  <tr>\n" .
         "    <td colspan=\"2\"><center><input type=\"submit\" value=\"Speichern\" /></center></td>\n" .
         "  </tr>\n";
}
else
{
    echo "  <tr>\n" .
         "    <td class=\"fail\">" . $data . "</td>\n" .
         "  </tr>\n";
}
echo "</table>\n</form>";

echo '
        <div class="copy">&copy; 2015 by B3-IT System GmbH</div>
    </body>
</html>
';
?>