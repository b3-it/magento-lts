<?php
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Resolution_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		$fieldset = $form->addFieldset('resolution_form', array(
				'legend' => Mage::helper('virtualgeo')->__('Resolution')
		));
		
		$fieldset->addField('use_resolution', 'select', array(
				'label'     => Mage::helper('regionallocation')->__('Use Resolution'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'product[use_resolution]',
				'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
		));

		$field = $fieldset->addField('resolution', 'multiselect', array(
				'label'     => Mage::helper('virtualgeo')->__('Verwendung'),
				'name'      => 'product[resolution][]',
				'defaultname'      => 'product[resolution_default][]',
				'values'    => Mage::getModel('virtualgeo/components_resolution')->getCollectionAsOptions($this->getProduct()->getId()),
				'value'		=> Mage::getModel('virtualgeo/components_resolutionproduct')->getValue4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId()),
				'default'	=> Mage::getModel('virtualgeo/components_resolutionproduct')->getDefaul4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId())
				
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
