<?php
/**
 * Paymentbase Resource-Setup-Model
 *
 * @category    Egovs
 * @package     Egovs_Paymentbase
 * @author      Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 -2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Resource_Setup extends Mage_Catalog_Model_Resource_Setup
{
	/**
	 * Updates anwenden
	 * 
	 * @return Egovs_Paymentbase_Model_Resource_Setup
	 * 
	 * @see Mage_Core_Model_Resource_Setup::applyUpdates()
	 */
	public function applyUpdates() {
		$myModule = substr(__CLASS__, 0, strpos(__CLASS__, '_Model'));
				
		//Gesamte Magento-Installation überprüfen
		//Nur wirkliche Abhängigkeiten Überprüfen
        /*Sollte in 1.9 nicht mehr problematisch sein
		if (!Egovs_Helper::dependenciesInstalled($myModule)) {
			Egovs_Helper::reinitAllowedModules($myModule);
				
			return $this;
		}
        */
	
		return parent::applyUpdates();
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
