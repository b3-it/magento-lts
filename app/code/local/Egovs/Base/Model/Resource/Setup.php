<?php
/**
 * Installer
 *
 * @category		Egovs
 * @package			Egovs_Base
 * @name			Egovs_Base_Model_Resource_Setup
 * @author			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright		Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license			http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * @version			0.1.0.0
 * @since			0.1.0.0
 *
 */
class Egovs_Base_Model_Resource_Setup extends Mage_Eav_Model_Entity_Setup
{
    /**
     * Call afterApplyAllUpdates method flag
     * @see Mage_Core_Model_Resource_Setup
     *
     * @var boolean
     */
    protected $_callAfterApplyAllUpdates = true;
    
    /**
     * Run each time after applying of all updates,
     * if setup model setted  $_callAfterApplyAllUpdates flag to true
     * 
     * http://vinaikopp.com/2014/11/03/magento-setup-scripts/
     *
     * @see Mage_Core_Model_Resource_Setup
     * @return Mage_Core_Model_Resource_Setup
     */
    public function afterApplyAllUpdates()
    {
        /** Flush all magento cache */
        Mage::app()->cleanCache();

        /** http://www.matthias-zeis.com/archiv/magento-indizes-manuell-neu-erstellen */
        /** run all of Magento Indexer */
        try {
            //$indexer = Mage::getSingleton('index/indexer');
            //$processCollection = $indexer->getProcessesCollection();
            //$processCollection->walk('reindexAll');
        } catch (Exception $e) {
        }

        return parent::afterApplyAllUpdates();
    }
    
    
    /**
     * Apply module resource install, upgrade and data scripts
     *
     * @see Mage_Core_Model_Resource_Setup
     * @return Mage_Core_Model_Resource_Setup
     */
    public function applyUpdates()
	{
		$myModule = substr(__CLASS__, 0, strpos(__CLASS__, '_Model'));
		
		//Gesamte Magento-Installation Überprüfen
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
