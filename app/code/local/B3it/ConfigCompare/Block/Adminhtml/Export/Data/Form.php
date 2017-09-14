<?php
class B3it_ConfigCompare_Block_Adminhtml_Export_Data_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Retrieve product
	 *
	 * @return Mage_Catalog_Model_Product
	 */
	public function getProduct() {
		return Mage::registry('current_product');
	}
	
	
	
	protected function _prepareForm() {
		$form = new Varien_Data_Form();
		
		//$form->setUseContainer(true);
		$this->setForm($form);
		$fieldset = $form->addFieldset('form', array('legend'=>Mage::helper('configcompare')->__('Export')));

		$field =$fieldset->addField('store_id', 'select', array(
      		'name'      => 'store_id',
      		'label'     => Mage::helper('cms')->__('Store View'),
      		'title'     => Mage::helper('cms')->__('Store View'),
      		'required'  => true,
      		'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, false),
      	));
		
		
		
		$fieldset->addField('configcompare_export', 'submit', array(
				'label'     => Mage::helper('configcompare')->__('Start Export'),
				'required'  => false,
				'name'      => 'start',
				'value'     => 'Start',
				'html_attributes' => array(),
		));
	
		return parent::_prepareForm();
	}
}