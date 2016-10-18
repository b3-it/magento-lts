<?php
error_reporting( E_ALL ^ E_NOTICE );
ob_start();

$sub        = array('/lib/Egovs', '\lib\Egovs');
$base       = str_replace( $sub, '', dirname(__FILE__) );
$config_xml = $base . '/app/etc/local.xml';
$data_xml   = array();

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

        $link -> exec("SET foreign_key_checks=0");

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


function get_table_list()
{
    global $data_xml;

    $result = get_sql('SHOW TABLES FROM ' . $data_xml['dbname']);

    $data = array();

    foreach( $result AS $key => $val )
    {
        $data[] = $val[0];
    }

    return $data;
}



echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">
    <head>
        <title>Magento - DB-Schredder</title>
        <style type="text/css">
            html  {background-color:#DCDCDC;}
            table {width:500px;}
            hr    {width:500px;}
            .okay {color:#008000;}
            .fail {color:#FF0000;}
        </style>
    </head>
    <body>
';

get_xml_data();

$data = get_table_list();

echo 'Magento - Datenbank-Shredder :: ' . $data_xml['dbname'] . '<hr />';
echo "<table summary=\"\">\n";

if ( count($data) )
{
    echo "  <tr>\n" .
         "    <td>\n";

    ob_flush();
    flush();

    $rest = array();

    do
    {
        while ( count($data) > 0 )
        {
            try
            {
                $err = set_sql('DROP TABLE IF EXISTS ' . $data[0], $data[0], $data[0]);

                echo '<div class="' . ( ($err == TRUE) ? 'okay' : 'fail' ) . '">[Code: ' . $err . '] ' . $data[0] . '</div>';

                if ( $err != TRUE )
                {
                    $rest[] = $data[0];
                }

                $data = array_slice($data, 1);
            }
            catch (Exception $e)
            {
                echo $data[0] . ' - Exception: ' .  $e -> getMessage();
            }

            echo "\n";

            ob_flush();
            flush();
        }

        $data = $rest;
        $rest = array();

        echo "<hr />\n";
    }
    while ( count($data) > 0 );

    echo "    </td>\n" .
         "  </tr>\n";
}
else
{
    echo "  <tr>\n" .
         "    <td>" . $data . "</td>\n" .
         "  </tr>\n";
}

echo "</table>";

echo '
        <div class="copy">&copy; 2015 by B3-IT System GmbH</div>
    </body>
</html>
';
?>