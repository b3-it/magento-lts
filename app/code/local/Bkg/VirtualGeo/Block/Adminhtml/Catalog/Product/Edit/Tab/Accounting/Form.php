<?php

/**
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Accounting_Form
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2018 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Accounting_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		$fieldset = $form->addFieldset('periode_form', array(
				'legend' => Mage::helper('virtualgeo')->__('Accounting')
		));

		

		$fieldset->addType('componentparts','Bkg_VirtualGeo_Block_Adminhtml_Widget_Form_Componentparts');
		$field = $fieldset->addField('accounting', 'componentparts', array(
				'label'     => Mage::helper('virtualgeo')->__('Usage'),
				'name'      => 'product[accounting]',
				'values'    => Mage::getModel('virtualgeo/components_accounting')->getCollectionAsOptions($this->getProduct()->getId()),
				'value'		=> Mage::getModel('virtualgeo/components_accountingproduct')->getComponents4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId()),

		));
	if ($field) {
			$field->setRenderer(
					$this->getLayout()->createBlock('virtualgeo/adminhtml_catalog_product_edit_tab_renderer_list')
					);
		}


		return parent::_prepareForm();
	}

	public function getProduct()
	{
		if (!$this->_productInstance) {
			if ($product = Mage::registry('product')) {
				$this->_productInstance = $product;
			} else {
				$this->_productInstance = Mage::getSingleton('catalog/product');
			}
		}

		return $this->_productInstance;
	}



}
