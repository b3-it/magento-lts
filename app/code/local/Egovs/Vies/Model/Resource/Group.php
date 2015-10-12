<?php
/**
 * Kundengruppen Auto-Zuordnungs-Model
 *
 * @category    Egovs
 * @package     Egovs_Vies
 * @author      Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Vies_Model_Resource_Group extends Mage_Core_Model_Resource_Db_Abstract
{
	/**
     * Primery key auto increment flag
     *
     * @var bool
     */
    protected $_isPkAutoIncrement    = false;
    
    /**
     * Resource initialization
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init('egovsvies/group_auto_assignment', 'entity_id');
    }

    /**
     * Initialize unique fields
     *
     * @return $this
     */
    protected function _initUniqueFields()
    {
        $this->_uniqueFields = array(
            array(
                'field' => 'entity_id',
                'title' => Mage::helper('egovsvies')->__('Constraint error:')
            ));

        return $this;
    }
    
    protected function _checkUnique(Mage_Core_Model_Abstract $object) {
    	$existent = array();
    	$fields = $this->getUniqueFields();
    	if (!empty($fields)) {
    		if (!is_array($fields)) {
    			$this->_uniqueFields = array(
    					array(
    							'field' => $fields,
    							'title' => $fields
    					));
    		}
    	
    		$data = new Varien_Object($this->_prepareDataForSave($object));
    		$select = $this->_getWriteAdapter()->select()
    			->from($this->getMainTable())
    		;
    	
    		foreach ($fields as $unique) {
    			$select->reset(Zend_Db_Select::WHERE);
    	
    			if (is_array($unique['field'])) {
    				foreach ($unique['field'] as $field) {
    					$select->where($field . '=?', trim($data->getData($field)));
    				}
    			} else {
    				$select->where($unique['field'] . '=?', trim($data->getData($unique['field'])));
    			}
    	
    			/* if ($object->getId()) {
    				$select->where($this->getIdFieldName() . '!=?', $object->getId());
    			} */
    	
    			$test = $this->_getWriteAdapter()->fetchRow($select);
    			if ($test) {
    				$existent[] = array(
    						'field' => $unique['title'],
    						'country_id' => $test['country_id'],
    						'group' => $test['customer_group_id'],
    						
    				);
    			}
    		}
    	}
    	
    	if (!empty($existent)) {
    		if (count($existent) == 1 ) {
    			/* @var $group Mage_Customer_Model_Group */
    			$group = Mage::getModel('customer/group')->load($existent[0]['group']);
    			
    			$locale = Mage::app()->getLocale();
    			$yesnocustom = Mage::getSingleton('egovsvies/adminhtml_system_config_source_yesnocustom')->toOptionArray();
    			foreach ($yesnocustom as $option) {
    				if (isset($option['value']) && $option['value'] == $group->getTaxvat()) {
    					$yesnocustom = $option['label'];
    					break;
    				}
    			}
    			if ($yesnocustom instanceof Egovs_Vies_Model_Adminhtml_System_Config_Source_Yesnocustom) {
    				$yesnocustom = $group->getTaxvat();
    			}
    			
    			//field wird schon bei Zuweisung übersetzt!
    			$error = $existent[0]['field'].': '.Mage::helper('egovsvies')->__(
    					'Country %s, check company: %s or check VAT: %s already assigned to group %s (ID: %s)',
    					$locale->getCountryTranslation($existent[0]['country_id']),
    					$group->getCompany() == 0 ? Mage::helper('egovsvies')->__('No') : Mage::helper('egovsvies')->__('Yes'),
    					$yesnocustom,
    					$group->getCustomerGroupCode(),
    					$group->getId()
    			);
    		} else {
    			$error = Mage::helper('core')->__('%s already exist.', implode(', ', $existent));
    		}
    		throw new Egovs_Vies_Model_Resource_Exception_Duplicate($error);
    	}
    	
    	return $this;
    }

    /**
     * Tut noch nichts besonderes
     *
     * @param Mage_Core_Model_Abstract $group Objekt
     * 
     * @throws Mage_Core_Exception
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _beforeDelete(Mage_Core_Model_Abstract $group)
    {
        return parent::_beforeDelete($group);
    }

    /**
     * Tut noch nichts besonderes
     *
     * @param Mage_Core_Model_Abstract $group Objekt
     * 
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _afterDelete(Mage_Core_Model_Abstract $group)
    {
        return parent::_afterDelete($group);
    }
    
    protected function _beforeSave(Mage_Core_Model_Abstract $object) {
    	return parent::_beforeSave($object);
    }
}
