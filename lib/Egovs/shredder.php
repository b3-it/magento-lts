<?php
error_reporting( E_ALL ^ E_NOTICE );
ob_start();

$sub        = array('/lib/egovs', '\lib\egovs');
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

    $data_xml = $params;
}

function set_sql($query = '')
{
    global $data_xml;

    $query = trim($query);

    if ( $query == '' )
    {
        $return = 'keine Abfrage!';
    }

    $link = mysql_connect($data_xml['config']['global']['resources']['default_setup']['connection']['host'],
                          $data_xml['config']['global']['resources']['default_setup']['connection']['username'],
                          $data_xml['config']['global']['resources']['default_setup']['connection']['password']
                         );
    if ( !$link )
    {
        return 'Error!';
    }

    $db = mysql_select_db($data_xml['config']['global']['resources']['default_setup']['connection']['dbname'], $link);

    if ( !$db )
    {
        return 'Fehler : ' . mysql_error();
    }

    $return = mysql_query($query, $link);

    mysql_close($link);

    return $return;
}

function get_table_list()
{
    global $data_xml;

    $result = set_sql('SHOW TABLES FROM ' . $data_xml['config']['global']['resources']['default_setup']['connection']['dbname']);

    $data = array();

    while ( $row = mysql_fetch_row($result) )
    {
        $data[] = $row[0];
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
            input {width:300px;}
            hr    {width:500px;}
            .okay {color:#008000;}
            .fail {color:#FF0000;}
        </style>
    </head>
    <body>
';

get_xml_data();

$data = get_table_list();

echo $data_xml['config']['global']['resources']['default_setup']['connection']['dbname'] . '<hr />';
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
                $result = set_sql('DROP TABLE IF EXISTS ' . $data[0]);

                echo '      ' . $data[0] . ' Return: ' . ( ($result == TRUE) ? 'OK' : 'Fehler' );

                if ( $result != TRUE )
                {
                    $rest[] = $data[0];
                }

                $data = array_slice($data, 1);
            }
            catch (Exception $e)
            {
                echo ' - Exception: ' .  $e -> getMessage();
            }

            echo "<br />\n";

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
        <div class="copy">&copy; 2013 by EDV-Beratung-Hempel</div>
    </body>
</html>
';
?>