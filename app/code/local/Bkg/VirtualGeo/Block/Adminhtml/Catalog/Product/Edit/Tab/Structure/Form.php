<?php
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Structure_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		$fieldset = $form->addFieldset('structure_form', array(
				'legend' => Mage::helper('virtualgeo')->__('Structure')
		));

		$fieldset->addField('use_structure', 'select', array(
				'label'     => Mage::helper('regionallocation')->__('Use Structure'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'product[use_structure]',
				'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
		));

		$field = $fieldset->addField('structure', 'multiselect', array(
				'label'     => Mage::helper('virtualgeo')->__('Usage'),
				'name'      => 'product[structure][]',
				'defaultname'      => 'product[structure_default][]',
				'values'    => Mage::getModel('virtualgeo/components_structure')->getCollectionAsOptions($this->getProduct()->getId()),
				'value'		=> Mage::getModel('virtualgeo/components_structureproduct')->getValue4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId()),
				'default'	=> Mage::getModel('virtualgeo/components_structureproduct')->getDefaul4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId())

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