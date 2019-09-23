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
	    /**
	     * @var Egovs_ProductFile_Helper_Data $helper
	     */
	    $helper = $this->helper('productfile');
	    return $helper->getFileUrl($this->getProductFile());
	}

	/**
	 * Liefert die URL zum Bild der Beschreibungsdatei
	 *
	 * @return string URL
	 */
	public function getProductImageUrl() {
	    /**
	     * @var Egovs_ProductFile_Helper_Data $helper
	     */
	    $helper = $this->helper('productfile');
	    return $helper->getFileUrl($this->getProductImage());
	}

	/**
	 * Prüft ob die Beschreibungsdatei vorhanden ist
	 *
	 * @return boolean
	 */
	public function existsProductFile() {
	    /**
	     * @var Egovs_ProductFile_Helper_Data $helper
	     */
	    $helper = $this->helper('productfile');
	    return $helper->fileExists($this->getProductFile());
	}

	/**
	 * Prüft ob ein Bild der Beschreibungsdatei vorhanden ist
	 *
	 * @return boolean
	 */
	public function existsProductImage() {
	    /**
	     * @var Egovs_ProductFile_Helper_Data $helper
	     */
	    $helper = $this->helper('productfile');
	    return $helper->fileExists($this->getProductImage());
	}

	/**
	 * Liefert den Dateinamen der Beschreibungsdatei
	 *
	 * @return string Name
	 */
	public function getProductFile() {
		return $this->getProduct()->getProductfile();
	}

	/**
	 * Liefert den Dateinamen zum Bild der Beschreibungsdatei
	 *
	 * @return string Name
	 */
	public function getProductImage() {
		return $this->getProduct()->getProductimage();
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
	 * Fügt Felder zum Form hinzu
	 *
	 * @return Mage_Adminhtml_Block_Widget_Form
	 *
	 * @see Mage_Adminhtml_Block_Widget_Form::_prepareForm()
	 */
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('productfile_form', array('legend'=>Mage::helper('productfile')->__('Product file')));
	
	
		//Damit das Element wirklich required ist muss:
		//'class'     => 'required-entry'
		//'required'  => true
		//hinzugefügt werden!!
	
		$element = $fieldset->addField(Egovs_ProductFile_Helper_Data::PRODUCT_FILE, 'file', array(
				'label'     	=> $this->__('Product file upload'),
				'name'      	=> Egovs_ProductFile_Helper_Data::PRODUCT_FILE,
				'note'			=> $this->__('Allowed file types') . ": " . $this->helper('productfile')->getFormattedProductFileAllowedExtensions(),
				'file'			=> $this->existsProductFile() ? $this->getProductFileUrl() : false,
		));
		$element->setRenderer(
				$this->getLayout()->createBlock('productfile/adminhtml_widget_form_renderer_fieldset_elementfile')
		);
		
		$element = $fieldset->addField(Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE, 'file', array(
				'label'     	=> $this->__('Product file image upload'),
				'name'      	=> Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE,
				'note'			=> $this->__('Allowed file types') . ": " . $this->helper('productfile')->getFormattedProductImageAllowedExtensions(),
				'image'			=> $this->existsProductImage() ? $this->getProductImageUrl(): false,
		));
		$element->setRenderer(
				$this->getLayout()->createBlock('productfile/adminhtml_widget_form_renderer_fieldset_elementfile')
		);
		
		$fieldset->addField(Egovs_ProductFile_Helper_Data::PRODUCT_FILE_DESCRIPTION, 'text', array(
				'label'		=> $this->__('Product file description'),
				'name'		=> Egovs_ProductFile_Helper_Data::PRODUCT_FILE_DESCRIPTION,
				'style'		=> 'width: 250px',
				'value'		=> $this->getProductFileDescription(),
		));
		
		$fieldset->addField(Egovs_ProductFile_Helper_Data::PRODUCT_DELETE_FILE, 'checkbox', array(
				'label'		=> $this->__('Remove product file'),
				'name'		=> Egovs_ProductFile_Helper_Data::PRODUCT_DELETE_FILE,
				'value'		=> 1,
				'checked'	=> false,
		));
		
		
		
		// TODO feststellen ob attribute aus default Store geladen wurden und checkbox anzeigen
		$store = $this->getProduct()->getStoreId();
		if( $store != 0)
		{
			$productId = $this->getProduct()->getId();
			
			$val1 = $this->_getAttributeStoreValue(Egovs_ProductFile_Helper_Data::PRODUCT_FILE, $productId, $store);
			$val2 = $this->_getAttributeStoreValue(Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE, $productId, $store);
			$val3 = $this->_getAttributeStoreValue(Egovs_ProductFile_Helper_Data::PRODUCT_FILE_DESCRIPTION, $productId, $store);
			$hasStoreSettings = ($val1 != null) || ($val2 != null) || ($val3 != null) ;
			
					
			$fieldset->addField('use_default', 'checkbox', array(
					'label'		=> $this->__('Use Default Value'),
					'name'		=> 'use_default_productfile',
					'checked'	=> !$hasStoreSettings,
			));
		}
		
		return parent::_prepareForm();
	}
	
	
	protected function _getAttributeStoreValue($attributeCode, $productId, $storeId)
	{
		/** @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */
		$attribute = $this->getProduct()->getResource()->getAttribute($attributeCode);
		if($attribute == null) return null;
		$read = $attribute->getResource()->getReadConnection();
		$sql = sprintf("SELECT value FROM %s WHERE attribute_id = %u AND entity_id= %u AND store_id= %u", $attribute->getBackendTable(), $attribute->getId(), $productId, $storeId);
		$data = $read->fetchRow($sql);
		
		if(isset($data['value']))
		{
			return $data['value'];
		}
		return null;
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