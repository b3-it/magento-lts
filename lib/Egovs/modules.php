<?php
error_reporting( E_ALL ^ E_NOTICE );

$ds               = DIRECTORY_SEPARATOR;  // System-Seperator verwenden
$script           = str_replace('\\', '/', $_SERVER['PHP_SELF']);
$test_mode        = FALSE;                                     // Im Test-Modus werden _new-Dateien erzeugt, um die Originale nicht zu ver㭤ern
$view_only        = ( isset($_GET['edit']) ? FALSE : TRUE );   // Alle Script-Aktionen abschalten
$sub              = join($ds, array('lib', 'Egovs'));
$base             = str_replace( $sub, '', dirname(__FILE__) );
$base_modules_xml = $base . $ds . join($ds, array('app', 'etc', 'modules')) . $ds;
$local_xml        = $base . $ds . join($ds, array('app', 'etc', 'local.xml'));
$exclude_modules  = array('Mage', 'Symmetrics', 'Phoenix', 'Netzarbeiter', 'RicoNeitzel', 'Cm');
$exclude_options  = array('Mage', 'Symmetrics', 'Phoenix', 'Netzarbeiter', 'RicoNeitzel', 'Cm');
$global_xml_file  = array();
$neueliste        = array();


////////////////////////////////////////////////////////////
///////////////////  START OF FUNCTIONS  ///////////////////
////////////////////////////////////////////////////////////

/*
 * Ausgabe eines gültigen XHTML-Headers
 */
function set_header($title = 'Magento - Modulverwaltung')
{
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
        <title>' . trim($title) . '</title>
        <style type="text/css">
            html          {background-color:#DCDCDC;}
            a             {font-size:15px; text-decoration:none; color:#0000FF;}
            .aktiv        {color:#008000; cursor:pointer;}
            .inaktiv      {color:#FF0000; cursor:pointer;}
            .modul_zeile  {padding:10px; width:1000px;}
            .modul_result {margin-left:20px; font-weight:bold; display:none; float:right;}
            .gerade       {background-color:#A9A9A9;}
            .abhaengig    {margin-left:20px; width:95%;}
            .copy         {display:block; padding:20px;}
            .result_okay  {color:#008000;}
            .result_fail  {color:#FF0000;}
            #mage         {cursor:pointer; width:1010px; height: 30px; background-color:#0000A0; color:#FFFFFF; padding:7px 0px 0px 10px; font-weight:bold;}
            #uploader     {display:none; left:100px; top:100px; z-index:1000; opacity:1; filter:Alpha(Opacity=100); position:absolute; border:2px solid #000000; background-color:#DCDCDC;}
            #upload       {cursor:pointer; color:#0000FF; display:inline-block; margin-left: 100px;}
            #start_upload {}
            #upload_title {background-color:#000000; color:#FFFFFF; font-weight:bold; padding:5px 0px 5px 10px;}
            #upload_hidde {float:right; padding:0px 10px 5px 0px; color:#FF0000; cursor:pointer;}
            #upload_text  {padding:20px;}

            #upload_frame {border:0px;}
            #upload_error {padding:5px; background-color:#FF0000; color:#FFFFFF; font-weight:bold;}
            #upload_change{padding:5px; background-color:#008000; color:#FFFFFF; font-weight:bold; margin-top: 20px;}

            #dummy        {left:0px; top:0px; z-index:999; position:absolute; background:#FFFFFF; opacity:.7; filter:Alpha(Opacity=70);}
            .min          {width:0%; height:0%;}
            .max          {width:100%; height:100%;}
        </style>
        <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
';
}



/* Wandelt ein Array in eine XML-Datei um
 *
 * @param       array      XML-Ausgabe als Array in welchem jeder Eintrag einer XML-Zeile entspricht
 * @param       array      XML-Array, welches in ein XML-File umgewandelt werden soll
 *
 * return       null
 */
function set_xml(&$output, $xml_array)
{
    $spacer = '    ';

    $output[] = '<?xml version="1.0" encoding="UTF-8"?>';
    $output[] = '<!DOCTYPE config>';
    $output[] = '<config>';
    $output[] = str_repeat($spacer, 1) . '<modules>';

    foreach($xml_array['config']['modules'] AS $key => $val)
    {
        $output[] = str_repeat($spacer, 2) . '<'   . $key   . '>';
        $output[] = str_repeat($spacer, 3) . '<active>'   . $val['active']   . '</active>';
        $output[] = str_repeat($spacer, 3) . '<codePool>' . $val['codePool'] . '</codePool>';

        if ( is_array($val['depends']) )
        {
            $output[] = str_repeat($spacer, 3) . '<depends>';

            foreach( $val['depends'] AS $keys => $value )
            {
                $output[] = str_repeat($spacer, 4) . '<' . $keys . ' />';
            }

            $output[] = str_repeat($spacer, 3) . '</depends>';
        }

        $output[] = str_repeat($spacer, 2) . '</'   . $key   . '>';
    }

    $output[] = str_repeat($spacer, 1) . '</modules>';
    $output[] = '</config>';
}

/* Ließt den Inhalt einer XML-Datei ein und wandelt diesen in ein
 * Mehrdimensiones Array um. Jeder Eintrag bekommt ein
 * Key=>Value-Paar zugeordnet
 *
 * @param       string      Dateiname der XML
 *
 * return       array       Fertig geparstes XML-Array
 */
function get_xml_data($file)
{
    if ( !filesize($file) )
    {
        return;
    }

    $fp   = fopen($file, "r");
    $data = fread($fp, filesize($file));
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

    return $params;
}

/* Ermittelt den Prefix eines Modules
 *
 * return      string       Name des Modules
 */
function get_prefix($name)
{
    return substr( $name, 0, strpos($name, '_') );
}

/* Erzeugt eine XML-Dateiliste in dem das XML-Modul-Vwerzeichniss ausgelesen wird
 * Es werden dabei auch gleich die Module sortiert um die Anzeige später zu vereinfachen.
 * MAGE-Module und andere "gesperrte" Module werden für Ajax-Bearbeitung deaktiviert
 *
 * return           null
 */
function get_xml_list()
{
    global $base_modules_xml, $exclude_modules;

    $basis_module  = array();
    $eigene_module = array();
    $dateiliste    = array();

    $dateiliste = glob($base_modules_xml . '*.xml');
    asort($dateiliste);

    foreach($dateiliste AS $filename)
    {
        if ( in_array( get_prefix(basename($filename)), $exclude_modules) )
        {
            $basis_module[] = $filename;
        }
        else
        {
            $eigene_module[] = $filename;
        }
    }

    $neu = array_merge($eigene_module, $basis_module);

    unset($dateiliste);
    unset($eigene_module);
    unset($basis_module);

    return $neu;
}

/* Erzeugt aus einer XML-Dateiliste ein Mehrdimensionales Array
 * welches alle Schlüssel der enthaltenen XML-Dateien beinhaltet
 *
 * @param      array       Array mit dem Ergebniss des XML-Parsers
 * @param      array       Liste mit Dateinamen zum parsen
 *
 * return      null
 */
function get_xml_file_modules(&$data_array, $file_list)
{
    foreach ( $file_list AS $file )
    {
        $xml = get_xml_data($file);
        
        if ( count($xml) )
        {
            $data_array[basename($file)] = array_keys($xml['config']['modules']);
        }
    }
}
////////////////////////////////////////////////////////////
///////////////////  END OF FUNCTIONS  /////////////////////
////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////
//////////////////////  START OF AJAX  /////////////////////
////////////////////////////////////////////////////////////
/*
 * Änderungen in der zugehörigen XML abspeichern
 */
if ( isset($_POST['change']) AND isset($_POST['status']) AND isset($_POST['module']) )
{
    if ( intval($_POST['edit']) == 1 )
    {
        $found      = FALSE;
        $new_status = ( ($_POST['status'] == 'true') ? 'true' : 'false');

        if (intval($_POST['change']) === 1)
        {
            $module = trim($_POST['module']);

            if ( in_array( get_prefix($module), $exclude_options) )
            {
                echo 'Internes Modul - Bearbeitung abgebrochen!';
            }
            else
            {
                get_xml_file_modules($global_xml_file, get_xml_list());

                foreach ( $global_xml_file AS $filename => $file_content )
                {
                    if ( array_search($module, $file_content) !== FALSE )
                    {
                        $found = TRUE;
                        break;
                    }
                }

                if ( $found === TRUE )
                {
                    $filename = $base_modules_xml . $filename;

                    if ( is_file($filename) AND is_writable($filename) )
                    {
                        $arr_xml = get_xml_data($filename);
                        $output  = array();

                        $arr_xml['config']['modules'][$module]['active'] = $new_status;

                        set_xml($output, $arr_xml);

                        if ( $test_mode === TRUE )
                        {
                            $filename .= '_new';
                        }

                        $fp = fopen($filename, "w");
                        if ( fwrite($fp, implode("\n", $output)) === FALSE )
                        {
                            echo '<span class="result_fail">FEHLER - beim erzeugen der Datei ' . basename($filename) . '</span>';
                        }
                        else
                        {
                            echo 'Datei ' . basename($filename) . ' gespeichert.';
                        }
                        fclose($fp);
                    }
                    else
                    {
                        echo '<span class="result_fail">Datei ' . basename($filename) . ' ist schreibgesch&uuml;tzt!</span>';
                    }
                }
                else
                {
                    echo '<span class="result_fail">keine Fundstelle vorhanden! . - ' . $filename . '</span>';
                }
            }
        }
        else
        {
            echo '<span class="result_fail">Anforderung kann nicht bearbeitet werden!</span>';
        }
        exit;
    }
    else
    {
        exit;
    }
}

/*
 * Configuration als serialisiertes Array herunterladen
 */
if ( isset($_GET['download']) )
{
    if ( $view_only === FALSE )
    {
        $config = get_xml_data($local_xml);
        $name   = 'config_' . $config['config']['global']['resources']['default_setup']['connection']['dbname'] .
                  '_' . date('Y-m-d_h-i-s') . '.txt';

        $neueliste = get_xml_list();
        get_xml_file_modules($global_xml_file, $neueliste);

        $settings = array();

        foreach ($neueliste AS $filename)
        {
            $xml = get_xml_data($filename);

            if ( count($xml) )
            {
                foreach($xml['config']['modules'] AS $key => $val)
                {
                    if ( !in_array( get_prefix($key), $exclude_options) )
                    {
                        $settings[basename($filename)][$key] = $val['active'];
                    }
                }
            }
        }

        unset($neueliste);

        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename=' . $name);
        header('Content-Transfer-Encoding: binary');

        echo serialize($settings);
        exit;
    }
}

if ( isset($_GET['show_upload']) )
{
    set_header('Konfiguration hochladen');
    echo '
        <script type="text/javascript">
            $(document).ready(function() {
            });
        </script>
    </head>
    <body>
        <form action="' . $script . '" method="post" id="frmUpload" enctype="multipart/form-data">
            <input type="hidden" name="upload" value="' . ( ($view_only === FALSE) ? '1' : '0' ) . '" />
            <input type="file" name="config_send" id="upload_file" />
            <br /><br />
            <input type="submit" value="Datei hochalden" />
        </form>
    </body>
</html>';

    exit;
}

/*
 * Configuration aus serialisiertem Array ermitteln
 */
if ( isset($_POST['upload']) )
{
    set_header('Konfiguration speichern');
    echo '
        </head>
    <body>';

    if ( intval($_POST['upload']) == 1 )
    {
        $file = $_FILES['config_send'];

        if ( $file['error'] == UPLOAD_ERR_OK )
        {
            $inhalt  = unserialize( file_get_contents($file['tmp_name']) );
            $neu     = 0;
            $sub_neu = 0;

            $neueliste = get_xml_list();
            get_xml_file_modules($global_xml_file, $neueliste);

            foreach ($neueliste AS $filename)
            {
                $xml = get_xml_data($filename);
                $sub = basename($filename);

                foreach($xml['config']['modules'] AS $key => $val)
                {
                    if ( !in_array( get_prefix($key), $exclude_options) )
                    {
                        if ( $val['active'] != $inhalt[$sub][$key] )
                        {
                            $neu++;
                            $sub_neu++;

                            // neuen Wert zuweisen
                            $xml['config']['modules'][$key]['active'] = $inhalt[$sub][$key];
                        }
                    }
                }

                if ( $sub_neu > 0 )
                {

                    set_xml($xml_neu, $xml);

                    $neu_file = $filename;

                    if ( $test_mode === TRUE )
                    {
                        $neu_file .= '_new';
                    }

                    $fp = fopen($neu_file, "w");
                    if ( fwrite($fp, implode("\n", $xml_neu)) === FALSE )
                    {
                        $ausgabe .= '<div class="result_fail">FEHLER - beim erzeugen der Datei ' . basename($neu_file) . '</div>';
                    }
                    else
                    {
                        $ausgabe .= '<div class="result_okay">Datei ' . basename($neu_file) . ' gespeichert.</div>';
                    }
                    fclose($fp);

                    $sub_neu  = 0;
                    $neu_file = '';
                    $xml_neu  = '';
                    $xml      = '';
                }
            }

            $ausgabe .= '<div id="upload_change">' . ( ($neu > 0) ? $neu : 'keine' ) . ' &Auml;nderung' . ( ($neu > 1) ? 'en' : '' ) . '</div>';

            echo $ausgabe;
        }
        else
        {
            switch ($file['error'])
            {
                case UPLOAD_ERR_INI_SIZE   : $error = 'Die hochgeladene Datei &uuml;berschreitet die in der Anweisung upload_max_filesize in php.ini festgelegte Gr&ouml;&szlig;e.';
                                             break;
                case UPLOAD_ERR_FORM_SIZE  : $error = 'Die hochgeladene Datei &uuml;berschreitet die in dem HTML Formular mittels der Anweisung MAX_FILE_SIZE angegebene maximale Dateigr&ouml;&szlig;e.';
                                             break;
                case UPLOAD_ERR_PARTIAL    : $error = 'Die Datei wurde nur teilweise hochgeladen.';
                                             break;
                case UPLOAD_ERR_NO_FILE    : $error = 'Es wurde keine Datei hochgeladen. ';
                                             break;
                case UPLOAD_ERR_NO_TMP_DIR : $error = 'Fehlender tempor&auml;rer Ordner.';
                                             break;
                case UPLOAD_ERR_CANT_WRITE : $error = 'Speichern der Datei auf die Festplatte ist fehlgeschlagen.';
                                             break;
                case UPLOAD_ERR_EXTENSION  : $error = 'Eine PHP Erweiterung hat den Upload der Datei gestoppt.';
                                             break;
                default                    : $error = 'unbekannter Fehler!';
                                             break;
            }
            echo '<span id="upload_error">' . $error . '</span>';
        }

    }
    else
    {
        echo '<span id="upload_error">keine Rechte, um die Datei hochzuladen!</span>';
    }

    echo '
    </body>
</html>';
    exit;
}

////////////////////////////////////////////////////////////
//////////////////////  ENDE OF AJAX  //////////////////////
////////////////////////////////////////////////////////////


set_header();
echo '
        <script type="text/javascript">
        function change_module(module_name)
        {
            var modul   = $("#" + module_name);
            var result  = $("#" + module_name + "_RESULT");
            var aktuell = modul.attr("class");
            var status  = "";

            result.html("").removeClass("result_okay").removeClass("result_fail");

            modul.removeClass(aktuell);

            if ( aktuell == "aktiv") {
                modul.addClass("inaktiv");
                status = "false";
            }
            else {
                modul.addClass("aktiv");
                status = "true";
            }

            $.ajax({
                url : "' . $script . '",
                type: "POST",
                data: {"change": 1,
                       "module": module_name,
                       "status": status,
                       "edit"  : "' . ( isset($_GET['edit']) ? '1' : '0' ) . '"
                      },

                success: function(data){
                             result.html(data)
                                   .addClass("result_okay")
                                   .fadeIn();
                         },
                error  : function(xhr, status, msg){
                             result.html(status + " - " + msg)
                                   .addClass("result_fail")
                                   .fadeIn();
                         }
            });
            return(false);
        }

        var last = 1;
        $(document).ready(function() {
            $("#mage").click(function() {
                $("#modules_mage").toggle("fast");

                if ( last == 0 ) {
                    $("#mage").text("+ MAGE-Module anzeigen");
                    last = 1;
                } else {
                    $("#mage").text("- MAGE-Module ausblenden");
                    last = 0;
                }
            });
            $("#mage").text("+ MAGE-Module anzeigen");

            $("#upload").click(function(){
                $("#dummy").removeClass("min")
                           .addClass("max");
                $("#uploader").fadeIn();
            });

            $("#upload_hidde").click(function(){
                $("#uploader").fadeOut(400, function(){
                    $("#upload_frame").attr("src", "' . $script . '?show_upload' . ( ($view_only === FALSE) ? '&edit' : '' ) . '");
                    $("#dummy").removeClass("max")
                               .addClass("min");
                });
            });
        });
        </script>
    </head>
    <body>

    <p>
        <a id="download" href="' . $script . '?' . ( ($view_only === FALSE) ? 'edit&amp;' : '' ) . 'download">Einstellungen herunterladen</a>
        <span id="upload">Einstellungen hochladen</span>
    </p>
    <div id="dummy" class="min"></div>
    <div id="uploader">
        <div id="upload_title">
            Datei hochladen
            <div id="upload_hidde">X</div>
        </div>
        <div id="upload_text">
            <iframe id="upload_frame" src="' . $script . '?show_upload' . ( ($view_only === FALSE) ? '&edit' : '' ) . '"></iframe>
        </div>
    </div>
';

$neueliste = get_xml_list();
get_xml_file_modules($global_xml_file, $neueliste);

$i    = 0;
$core = FALSE;

foreach ($neueliste AS $filename)
{
    $xml = get_xml_data($filename);
    
    if ( count($xml) )
    {
        foreach($xml['config']['modules'] AS $key => $val)
        {
            if ( in_array( get_prefix($key), $exclude_options) AND ($core === FALSE) )
            {
                echo "<div id=\"mage\"></div>\n" .
                    "<div id=\"modules_mage\" style=\"display:none;\">\n";
                $core = TRUE;
            }
            
            if ( $view_only === FALSE )
            {
                if ( in_array( get_prefix($key), $exclude_options) )
                {
                    $click = ' onClick="alert(\'BASIS-Module k&ouml;nnen nicht ver&auml;ndert werden!\');"';
                }
                else
                {
                    $click = ' onClick="change_module(\'' . $key . '\');"';
                }
            }
            else
            {
                $click = '';
            }
            
            $aktiv = ( ($val['active'] === 'true') ? '<span class="aktiv"' : '<span class="inaktiv"' );
            $class = ( ($i % 2 == 0) ? ' gerade' : '' );
            echo '<div class="modul_zeile' . $class . '">' . $aktiv . ' id="' . $key . '"' . $click . '>' . $key . '</span>' .
                '<span class="modul_result" id="' . $key . '_RESULT"></span>';
            
            if ( isset($val['depends']) )
            {
                if ( is_array($val['depends']) )
                {
                    echo '<br />Abh&auml;ngigkeiten:<br /><div class="abhaengig">';
                    
                    $sub = array();
                    foreach($val['depends'] AS $keys => $values)
                    {
                        $sub[] = '<a href="' . $script . '#' . $keys . '">' . $keys . '</a>';
                    }
                    
                    echo implode(', ', $sub ) . '</div>';
                }
            }
            
            echo "</div>\n";
            $i++;
        }
    }
}

unset($neueliste);

echo '</div>

        <div class="copy">&copy; 2017 by B3-IT Systeme GmbH</div>
    </body>
</html>
';
?>