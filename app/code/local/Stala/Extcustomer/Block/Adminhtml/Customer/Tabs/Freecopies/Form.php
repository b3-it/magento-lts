<?php

class Stala_Extcustomer_Block_Adminhtml_Customer_Tabs_Freecopies_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected $_customer = null;
	
	/**
	 * Get current customer
	 * 
	 * @return Mage_Customer_Model_Customer
	 */
	protected function _getCustomer() {
		if (!$this->_customer) {
			$this->_customer = Mage::registry('current_customer');
		}
		
		return $this->_customer;
	}
	
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('freecopies_form', array('legend'=>Mage::helper('extcustomer')->__('Freecopies for all products')));
		 

		$fieldset->addField('freecopies_count', 'text', array(
          	'label'     => Mage::helper('extcustomer')->__('Set Freecopies'),
			//'disabled' => false,
			//'readonly'  => false,
          	'name'      => "freecopies_count",
			'note'		=> Mage::helper('extcustomer')->__('Delete all entries with values smaller than zero')
		));

		/*$fieldset->addField('base_freecopies', 'text', array(
          'label'     => Mage::helper('extcustomer')->__('Base Freecopies'),
          'disabled' => true,
          'readonly'  => true,
          'name'      => "base_freecopies",
		));*/


		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $this->_getCustomer();
		if ($customer != null) {
			$attributes = array();
			
			if (($base_freecopies = $customer->getAttribute('stala_base_freecopies'))) {
				$base_freecopies->setIsVisible(true);
				$attributes[] = $base_freecopies;	
			}
			
			if (count($attributes) > 0) {
				$this->_setFieldset($attributes, $fieldset);
				$form->getElement('stala_base_freecopies')->setDisabled('disabled');
			}
		}
		 
		return parent::_prepareForm();
	}
	
	protected function _initFormValues()
    {
    	if (!$this->_getCustomer()) {
    		return parent::_initFormValues();
    	}
    	foreach ($this->_getCustomer()->getAttributes() as $attribute) {
    		/* @var $element Varien_Data_Form_Element_Fieldset */
    		foreach ($this->getForm()->getElements() as $fieldSet) {
    			foreach ($fieldSet->getElements() as $field) {
    				if (strcasecmp($field->getHtmlId(), $attribute->getAttributeCode()) != 0)
    					continue;
    				
    				$value = $this->_getCustomer()->getData($attribute->getAttributeCode());
    				$field->setValue($value);
    			}
    		}
    	}
    	
        return parent::_initFormValues();
    }
}