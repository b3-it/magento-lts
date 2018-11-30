<?php
/**
 * Installer für PDF-Configuration
 *
 * @category   	Egovs
 * @package    	Egovs_Base
 * @author 		René Mütterlein <r.muetterlein@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3-IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Helper_Pdfsetup_Data extends Mage_Core_Helper_Abstract
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
     *         'scope'       => 'default',                 # Scope, in welchen das Logo hinterlegt werden soll
     *         'scope_id'    => '0',                       # ScopeID, für welchen das Logo gelten soll
     *         'destination' => 'tuc_logo_invoice.png',    # Dateiname der Ziel-Datei
     *         'source'      => 'tuc_logo_invoice.png',    # Dateiname der Quell-Datei
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
    public function setPdfConfig($configData, $imagePath, $installer)
    {
        // Pfad zum Magento-Skin
        $skinPath  = Mage::getBaseDir('skin') . DS . 'frontend' . DS . $imagePath;

        // Pfad zum Media von Magento
        $mediaPath = Mage::getBaseDir('media');

        foreach($configData AS $key => $entry) {
            $logo_to1 = $logo_to2 = $logo_from = '';

            if ( $entry['scope'] == 'default' ) {
                $value = implode(DS, array($entry['scope'], $entry['source']));
            }
            else {
                $value = implode(DS, array($entry['scope'], $entry['scope_id'], $entry['source']));
            }

            $logo_from = implode(DS, array($skinPath, $entry['source']));
            $logo_to1  = implode(DS, array($mediaPath, 'sales', 'store', 'logo', $value));
            $logo_to2  = implode(DS, array($mediaPath, 'sales', 'store', 'logo_html', $value));

            $installer->setConfigData('sales/identity/logo'     , $value, $entry['scope'], $entry['scope_id']);
            $installer->setConfigData('sales/identity/logo_html', $value, $entry['scope'], $entry['scope_id']);

            $this->_copyFileToMedia($logo_from, $logo_to1);
            $this->_copyFileToMedia($logo_from, $logo_to2);
        }
    }

    /**
     * Kopiert eine Quelle-Datei ins Media-Verzeichnis
     *
     * @param string     $source         kompletter Pfad zur Quell-Datei
     * @param string     $destination    kompletter Pfad zur Ziel-Datei
     */
    private function _copyFileToMedia($source = null, $destination = null)
    {
        if ( is_null($source) OR is_null($destination) ) {
            return;
        }

        if ( !is_file($source) ) {
            return;
        }

        // Wenn es die LOGO-Datei ist, ....
        if ( strlen($destination) ) {
            // Ziel-Pfad ist nicht da => anlegen
            if ( !is_dir(dirname($destination)) ) {
                mkdir(dirname($destination), $this->_defaultDirectoryMask, TRUE);
            }

            // Die Datei existiert nicht => kopieren
            if ( !is_file($destination) ) {
                copy($source, $destination);
            }
        }
    }
}