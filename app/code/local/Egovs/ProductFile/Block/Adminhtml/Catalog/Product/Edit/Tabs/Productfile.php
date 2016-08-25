<?php
/**
 * Observer zum Speichern von Beschreibungsinformationen zu Produkten *
 *
 * @category   	Egovs
 * @package    	Egovs_ProductFile
 * @author 		Jan Knipper <j.knipper@edv-beratung-hempel.de>
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_ProductFile_Block_Adminhtml_Catalog_Product_Edit_Tabs_Productfile extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    private $_file_pattern = "/[^a-zA-Z0-9-_.\/]/i";

    /**
     * Fügt Felder zum Form hinzu
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     *
     * @see Mage_Adminhtml_Block_Widget_Form::_prepareForm()
     */
    protected function _prepareForm() {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('productfile_form', array('legend'=>Mage::helper('productfile')->__('Product file')));

        $element = $fieldset->addField(Egovs_ProductFile_Helper_Data::PRODUCT_FILE, 'file', array(
            'label' => $this->__('Product file upload'),
            'name'  => Egovs_ProductFile_Helper_Data::PRODUCT_FILE,
            'note'  => $this->__('Allowed file types') . ": " . $this->helper('productfile')->getFormattedProductFileAllowedExtensions(),
            'file'  => $this->existsProductFile() ? $this->getProductFileUrl() : false,
        ));
        $element->setRenderer(
            $this->getLayout()->createBlock('productfile/adminhtml_widget_form_renderer_fieldset_elementfile')
        );

        $element = $fieldset->addField(Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE, 'file', array(
            'label' => $this->__('Product file image upload'),
            'name'  => Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE,
            'note'	=> $this->__('Allowed file types') . ": " . $this->helper('productfile')->getFormattedProductImageAllowedExtensions(),
            'image'	=> $this->existsProductImage() ? $this->getProductImageUrl(): false,
        ));
        $element->setRenderer(
            $this->getLayout()->createBlock('productfile/adminhtml_widget_form_renderer_fieldset_elementfile')
        );

        $fieldset->addField(Egovs_ProductFile_Helper_Data::PRODUCT_FILE_DESCRIPTION, 'text', array(
            'label' => $this->__('Product file description'),
            'name'  => Egovs_ProductFile_Helper_Data::PRODUCT_FILE_DESCRIPTION,
            'style' => 'width: 250px',
            'value' => $this->getProductFileDescription(),
        ));

        $fieldset->addField(Egovs_ProductFile_Helper_Data::PRODUCT_DELETE_FILE, 'checkbox', array(
            'label'		=> $this->__('Remove product file'),
            'name'		=> Egovs_ProductFile_Helper_Data::PRODUCT_DELETE_FILE,
            'value'		=> 1,
            'checked'	=> false,
        ));

        return parent::_prepareForm();
    }

    /**
     * Gibt die aktuell zu bearbeitente Produkinstanz zurück.
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct() {
        return Mage::registry('current_product');
    }

    /**
     * Liefert die URL zur Beschreibungsdatei
     *
     * @return string URL
     */
    public function getProductFileUrl() {
        $url =  Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).
                $this->helper('productfile')->getProductFileUploadDirectory().
                DS . basename($this->getProductFile());

        return $url;
    }
    /**
     * Liefert die URL zum Bild der Beschreibungsdatei
     *
     * @return string URL
     */
    public function getProductImageUrl() {
        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).
               $this->helper('productfile')->getProductFileUploadDirectory().
               DS . trim($this->getProductImage());
        return $url;
    }
    /**
     * Prüft ob die Beschreibungsdatei vorhanden ist
     *
     * @return boolean
     */
    public function existsProductFile() {
        $path = Mage::getBaseDir('media') . DS .
                $this->helper('productfile')->getProductFileUploadDirectory() . DS .
                preg_replace($this->_file_pattern, "_", $this->getProduct()->getProductFile() );

        if (file_exists($path) && !is_dir($path)) {
            return true;
        }

        return false;
    }

    /**
     * Prüft ob ein Bild der Beschreibungsdatei vorhanden ist
     *
     * @return boolean
     */
    public function existsProductImage() {
        $path = Mage::getBaseDir('media') . DS .
                $this->helper('productfile')->getProductFileUploadDirectory() . DS .
                preg_replace($this->_file_pattern, "_", $this->getProductImage());

        if (file_exists($path) && !is_dir($path)) {
            return true;
        }

        return false;
    }

    /**
     * Liefert den Dateinamen der Beschreibungsdatei
     *
     * @return string Name
     */
    public function getProductFile() {
        return $this->helper('productfile')->getProductFileFullName();
    }

    /**
     * Liefert den Dateinamen zum Bild der Beschreibungsdatei
     *
     * @return string Name
     */
    public function getProductImage() {
        return preg_replace($this->_file_pattern, "_", $this->getProduct()->getProductimage());
    }

    /**
     * Gibt die Beschreibung für die Beschreibungsdatei zurück
     *
     * @return string
     */
    public function getProductFileDescription() {
        return $this->escapeHtml($this->getProduct()->getProductfiledescription());
    }

    /**
     * Return Tab Label
     *
     * @return string
     */
    public function getTabLabel() {
        return Mage::helper('productfile')->__('Product file');
    }

    /**
     * Return Tab Titel
     *
     * @return string
     */
    public function getTabTitle() {
        return Mage::helper('productfile')->__('Product file');
    }

    /**
     * Darf Tab angezeigt werden
     *
     * @return boolean
     */
    public function canShowTab() {
        return true;
    }

    /**
     * Ist der Tab versteckt
     *
     * @return boolean
     */
    public function isHidden() {
        return false;
    }
}