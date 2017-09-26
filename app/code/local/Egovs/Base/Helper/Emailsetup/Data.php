<?php
/**
 * Installer für eMail-Configuration
 * 
 * @category   	Egovs
 * @package    	Egovs_Base
 * @author 		René Mütterlein <r.muetterlein@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3-IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Helper_Emailsetup_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Datei-Maske zum anlegen neuer Verzeichnis-Strukturen im Media-Verzeichnis
     * 
     * @var string
     */
    private $_defaultDirectoryMask = '0750';

    /**
     * Installiert eine neue eMail-Konfiguration auf unterschiedlichen Ebenen
     * 
     * Bsp $configData:
     * array(
     *     0 => array(
     *         'scope'       => 'default',                        Scope, für welchen die Einstellungen gelten
     *         'scope_id'    => '0',                              ScopeID für welche die Einstellungen gelten
     *         'default'     => 'email_logo_default.png',         Dateiname der Quell-Datei
     *         'data'        => array(
     *             'logo'        => 'logo_email_allgemein.png',   Dateiname der Ziel-Datei im Media-Verzeichnis
     *             'logo_alt'    => 'Logo tubaf allgemein',       Alternativer Titel
     *             'logo_width'  => '920',                        Breite des Logos in Pixel
     *             'logo_height' => '104',                        Höhe des Logos in Pixel
     *         )
     *     ),
     *     ...
     * );
     * 
     * 
     * 
     * @param array                        $configData      Array mit Konfigurations-Daten
     * @param string                       $imagePath       Skin-Pfad für Quell-Datei(en)
     * @param Mage_Eav_Model_Entity_Setup  $installer       Installer-Object
     */
    public function setEmailConfig($configData, $imagePath, $installer)
    {
        // Tabelle mit der Config
        $cfgTable  = $installer->getTable('core/config_data'); 

        // Pfad zum Magento-Skin
        $skinPath  = Mage::getBaseDir('skin') . DS . 'frontend' . DS . $imagePath;

        // Pfad zum Media von Magento
        $mediaPath = Mage::getBaseDir('media');

        // Unter-Verzeichnis im Media
        $destPath  = 'email' . DS . 'logo';
        
        foreach($configData AS $key => $entry) {
            foreach($entry['data'] AS $path => $value) {
                $path = 'design/email/' . $path;

                $logo_to = $logo_from = '';
                
                if ( $path == 'design/email/logo' ) {
                    if ( $entry['scope'] == 'default' ) {
                        $value = $entry['scope'] . '/' . $value;
                    }
                    else {
                        $value = $entry['scope'] . '/' . $entry['scope_id'] . '/' . $value;
                    }
                    
                    // Pfade zur LOGO-Dateien
                    $logo_to   = $mediaPath . DS . $destPath    . DS . $value;
                    $logo_from = $skinPath  . DS . $entry['default'];
                }

                // Herausfinden, ob ein Eintrag mit den Scope-Daten schon vorhanden ist
                $id = $installer->getConnection()->fetchOne("SELECT `config_id` FROM `{$cfgTable}` WHERE `path` = '{$path}' AND " .
                                                            "`scope` = '{$entry['scope']}' AND `scope_id` = '{$entry['scope_id']}';");
                
                if (!$id) {
                    // Eintrag nicht vorhanden => Anlegen
                    $installer->run("INSERT INTO `{$cfgTable}` (`scope`, `scope_id`, `path`, `value`)" .
                                    "VALUES ('{$entry['scope']}', '{$entry['scope_id']}', '{$path}', '{$value}');");
                }
                else {
                    // Eintrag vorhanden => Update
                    $installer->run("UPDATE `{$cfgTable}` SET `value` = '{$value}' WHERE `config_id` = '{$id}';");
                }
                
                // Wenn es die LOGO-Datei ist, ....
                if ( strlen($logo_to) ) {
                    // Ziel-Pfad ist nicht da => anlegen
                    if ( !is_dir(dirname($logo_to)) ) {
                        mkdir(dirname($logo_to), $this->_defaultDirectoryMask, TRUE);
                    }
                    
                    // Die Datei existiert nicht => kopieren
                    if ( !is_file($logo_to) ) {
                        copy($logo_from, $logo_to);
                    }
                }
            }
        }
    }
    
    /**
     * Installiert neue eMail-Templates, welche aus einer Datei gelesen werden
     * 
     * Bsp $configData:
     * array(
     *      0 => array(
     *          'template' => 'header.htm',            // Name der Datei mit dem Template-Code
     *          'name'     => 'eMail-Header',          // Name in der eMail-Template-Tabelle
     *          'topic'    => 'Email - Kopfzeile',     // Titel in der eMail-Template-Tabelle
     *          'path'     => 'design/email/header'    // Pfad in der Config-Tabelle
     *      ),
     * );
     * 
     * 
     * 
     * @param array                        $configData      Array mit Konfigurations-Daten
     * @param string                       $templatePath    Skin-Pfad für Quell-Datei(en)
     * @param Mage_Eav_Model_Entity_Setup  $installer       Installer-Object
     */
    public function setEmailTemplates($configData, $templatePath, $installer)
    {
        // Tabelle mit der eMail-Templates
        $emailTable   = $installer->getTable('core/email_template');

        // Pfad zum Magento-Skin
        $templatePath = Mage::getBaseDir('skin') . DS . 'frontend' . DS . $templatePath;

        foreach($configData AS $key => $entry) {
            $id = $installer->getConnection()->fetchOne("SELECT `template_id` FROM `{$emailTable}` WHERE `template_code` = '{$entry['name']}';");
            
            if (!$id) {
                $content  = file_get_contents($templatePath . DS . $entry['template']);
                $template = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));

                $installer->run("INSERT INTO `{$emailTable}` (`template_code`, `template_text`, `template_type`, `template_subject`) " .
                                "VALUES ('{$entry['name']}', '{$template}', '2', '{$entry['topic']}');");

                $id = $installer->getConnection()->fetchOne("SELECT `template_id` FROM `{$emailTable}` WHERE `template_code` = '{$entry['name']}';");
                $installer->setConfigData($entry['path'], $id);
            }
        }
    }
    
    /**
     * Läd alle eMail-Templates und verändert den Inhalt.
     * Nach der Anpassung wird das Template zurück gespeichert.
     * 
     * @param array    $replace            Array mit $key => $val was ersetzt werden soll
     * @param string   $header             String, welcher als Header an den Anfang eingefügt werden soll
     * @param string   $footer             String, welcher als Footer an alle Templates angehängt weerden soll
     * @param integer  $styleCounter       Anzahl der Zeilen im Style-Tag (eventuell wird der Tabluator nicht korrekt erkannt)
     */
    public function replaceEmailTemplateContent($replace = null, $header = '', $footer = '', $styleCounter = 0)
    {
        $email_arr = Mage::getModel('core/email_template')->getCollection();
        foreach($email_arr AS $email) {
            $code = $email->getTemplateCode();
            
            if ( ($code == 'eMail-Header') OR ($code == 'eMail-Footer') ) {
                // nicht in sich selbst eintragen
                continue;
            }
            
            $id  = $email->getTemplateId();
            $new = $old = $email->getTemplateText();
            
            if ( is_array($replace) AND count($replace) ) {
                $new = str_replace(array_keys($replace), array_values($replace), $new);
            }
            
            if ($styleCounter > 0) {
                // falls der Tablulator im Template wird nicht erkannt
                $arr = explode("\n", trim($new));
                if ( (trim($arr[0]) == '<style type="text/css">') ) {
                    for( $i = 0; $i < $styleCounter; $i++ ) {
                        unset($arr[$i]);
                    }
                    $new = implode("\n", $arr);
                }
            }
            
            if ( strlen($header) ) {
                // Prüfen, ob der Header in allen Templates eingefügt ist
                $arr = explode("\n", trim($new));
                if ( $arr[0] != $header ) {
                    $new = $header . "\n" . $new;
                }
            }
            
            if ( $old != $new ) {
                if ( strlen($footer) ) {
                    $new .= "\n" . $footer;
                }
                
                $model = Mage::getModel('core/email_template')->load($id);
                $model->setData('template_text', $new)->save();
            }
        }
    }
}