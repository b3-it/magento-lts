<?php
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Georef_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		$fieldset = $form->addFieldset('periode_form', array(
				'legend' => Mage::helper('virtualgeo')->__('Georef')
		));

		

		$fieldset->addType('componentparts','Bkg_VirtualGeo_Block_Adminhtml_Widget_Form_Componentparts');
		$field = $fieldset->addField('georef', 'componentparts', array(
				'label'     => Mage::helper('virtualgeo')->__('Usage'),
				'name'      => 'product[georef]',
				'values'    => Mage::getModel('virtualgeo/components_georef')->getCollectionAsOptions($this->getProduct()->getId()),
				'value'		=> Mage::getModel('virtualgeo/components_georefproduct')->getComponents4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId()),

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
