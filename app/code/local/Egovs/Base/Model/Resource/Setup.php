<?php
/**
 * Customer resource setup model
 *
 * @category    Mage
 * @package     Mage_Customer
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Base_Model_Resource_Setup extends Mage_Eav_Model_Entity_Setup
{
	public function applyUpdates()
	{
		$myModule = substr(__CLASS__, 0, strpos(__CLASS__, '_Model'));
		
		//Gesamte Magento-Installation überprüfen
		//Nur wirkliche Abhängigkeiten Überprüfen
		if (!Egovs_Helper::dependenciesInstalled($myModule)) {
			Egovs_Helper::reinitAllowedModules($myModule);
				
			return $this;
		}
	
		return parent::applyUpdates();
	}
	
    /**
     * Prepare customer attribute values to save in additional table
     *
     * @param array $attr
     * @return array
     */
    protected function _prepareValues($attr)
    {
        $data = parent::_prepareValues($attr);
        $data = array_merge($data, array(
            'is_visible'                => $this->_getValue($attr, 'visible', 1),
            'is_system'                 => $this->_getValue($attr, 'system', 0),
            'input_filter'              => $this->_getValue($attr, 'input_filter', null),
            'multiline_count'           => $this->_getValue($attr, 'multiline_count', 0),
            'validate_rules'            => $this->_getValue($attr, 'validate_rules', null),
            'data_model'                => $this->_getValue($attr, 'data', null),
            'sort_order'                => $this->_getValue($attr, 'position', 0)
        ));

        return $data;
    }

    /**
     * Add customer attribute to customer forms
     * 
     * Folgende Formcodes sind möglich:
     * <ul>
     * 	<li>adminhtml_only</li>
     * 	<li>admin_checkout</li>
     * </ul>
     * 
     * @param mixed $attributeCode   ID oder Attributecode des Attributes
     * @param array $usedInFormsData Array von möglichen Formcodes
     *
     * @return void
     */
    public function installCustomerForms($attributeCode, $usedInFormsData = array()) {
        $customer           = (int)$this->getEntityTypeId('customer');

        $attribute = $this->getAttribute($customer, $attributeCode);
        
        if (!$attribute) {
        	return;
        }

        $data       = array();
        $attributeId = $attribute['attribute_id'];
        $attribute['system'] = isset($attribute['system']) ? $attribute['system'] : true;
        $attribute['visible'] = isset($attribute['visible']) ? $attribute['visible'] : true;
        if ($attribute['system'] != true || $attribute['visible'] != false) {
        	$usedInForms = array(
        			'customer_account_create',
        			'customer_account_edit',
        			'checkout_register',
        	);
        	if (!empty($usedInFormsData['adminhtml_only'])) {
        		$usedInForms = array('adminhtml_customer');
        	} else {
        		$usedInForms[] = 'adminhtml_customer';
        	}
        	if (!empty($usedInFormsData['admin_checkout'])) {
        		$usedInForms[] = 'adminhtml_checkout';
        	}
        	foreach ($usedInForms as $formCode) {
        		$data[] = array(
        				'form_code'     => $formCode,
        				'attribute_id'  => $attributeId
        		);
        	}
        }

        if ($data) {
            $this->getConnection()->insertMultiple($this->getTable('customer/form_attribute'), $data);
        }
    }
}
