<?php
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Format_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		$fieldset = $form->addFieldset('format_form', array(
				'legend' => Mage::helper('virtualgeo')->__('Format')
		));
		
		$fieldset->addField('use_format', 'select', array(
				'label'     => Mage::helper('regionallocation')->__('Use Format'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'product[use_format]',
				'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
		));

		$categoriesField = $fieldset->addField('format', 'multiselect', array(
				'label'     => Mage::helper('virtualgeo')->__('Verwendung'),
				'name'      => 'product[format][]',
				'values'    => Mage::getModel('virtualgeo/components_format')->getCollectionAsOptions($this->getProduct()->getId()),
				'value'		=> Mage::getModel('virtualgeo/components_formatproduct')->getValue4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId())
				
		));
		if (false) {
			$categoriesField->setRenderer(
					$this->getLayout()->createBlock('informationservice/adminhtml_widget_form_renderer_fieldset_selectlevels')
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
