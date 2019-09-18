<?php
/**
 * Beschreibungsdatei für Produktinformationen
 *
 * PHP version 5
 *
 * @category	  Egovs
 * @package		  Egovs_ProductFile
 * @name        Egovs_ProductFile_Model_Entity_Attribute_Frontend_Productfile
 * @author      Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright	  Copyright (c) 2015 B3-it System GmbH
 * @license		  http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
 * Beschreibungsdatei für Produktinformationen
 *
 * @category	  Egovs
 * @package		  Egovs_ProductFile
 * @name        Egovs_ProductFile_Model_Entity_Attribute_Frontend_Productfile
 * @author      Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright	  Copyright (c) 2015 B3-it System GmbH
 * @license		  http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_ProductFile_Model_Entity_Attribute_Frontend_Productfile extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{
    /**
     * Renderfunktion zum Setzen aller Daten für den Zellinhalt der Tabelle
     * auf der Registerkarte "Zusatzinformationen"
     *
     * @return string
     */
    public function getValue(Varien_Object $object) {
        $_product = $this->__getProduct();

        $_fname = $_product->getProductfile();
        $_fileUrl  = $this->__getFullURL() . '/' . $_fname;
        $_file = $this->__getFullPath() . DS . $_fname;

        if ( is_file($_file) ) {
            $_descr = Mage::helper('core')->escapeHtml($_product->getProductfiledescription());
            $_fsize = Mage::helper('productfile')->getFormatBytes( filesize($_file) );
            $_image = Mage::helper('productfile')->getThumbnailProductImageUrl(Mage::helper('core')->escapeHtml($_product->getProductimage()));

            $_img_descr = Mage::helper('productfile')->__('ProductFile description');

            $html = array();

            if ( strlen($_image) ) {
                $html[] = '<img src="' . $_image . '" alt="' . $_img_descr . '" title="' . $_img_descr . '" />';
            }

            $html[] = '<div id="egov-productfile" class="egov-productfile-block">';

            if ( strlen($_descr) ) {
                $html[] = '  <div id="egov-productfile-description">';
                $html[] = '    ' . $_descr;
                $html[] = '  </div>';
            }

            $html[] = '  <a href="' . $_fileUrl . '" target="_blank">' . basename($_fname) . '</a>';
            $html[] = '  <span>(' . $_fsize . ')</span>';
            $html[] = '</div>';

            return implode("\n", $html);
        }
        else {
            return;
        }
    }

    /**
     * Ermittelt die Daten des aktuellen Produktes
     *
     * @return Mage_Catalog_Model_Product
     */
    private function __getProduct() {
        return Mage::registry('current_product');
    }

    /**
     * Ermittelt die aktuelle Datei-URL im physischen Dateisystem
     *
     * @return string
     */
    private function __getFullPath() {
        $pathData = array(
                          Mage::getBaseDir('media'),
                          Mage::getStoreConfig('settings/productfile_upload_directory/dir')
                      );

        return implode(DS, $pathData);
    }

    /**
     * Ermittelt die aktuelle Frontend-Media-URL
     *
     * @return string
     */
    private function __getFullURL() {
        $pathData = array(
                          Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA),
                          Mage::getStoreConfig('settings/productfile_upload_directory/dir')
                      );

        return implode('', $pathData);
    }
}
