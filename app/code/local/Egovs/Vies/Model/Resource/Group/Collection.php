<?php
/**
 * Kundengruppen-Länderzuordnung Collection
 *
 * @category    Egovs
 * @package     Egovs_Vies
 * @author      Frank Rochlitzer <f.rochlitzer@trw-net.de>
 */
class Egovs_Vies_Model_Resource_Group_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Resource initialization
     */
    protected function _construct()
    {
        $this->_init('egovsvies/group');
    }
    
    /**
     * Adding item to item array
     *
     * @param   Varien_Object $item
     * @return  Varien_Data_Collection
     */
    public function addItem(Varien_Object $item)
    {
    	try {
    		return parent::addItem($item);
    	} catch (Exception $e) {
    		if (isset($this->_items[$item->getId()])) {
    			/* @var $existingItem Egovs_Vies_Model_Group */
    			$existingItem = $this->_items[$item->getId()];
    			$orig = $existingItem->getOrigData();
    			if (empty($orig)) {
    				$existingItem = $item;
    			}
    		} else {
    			$existingItem = new Varien_Object(array('customer_group_id' => 'unknown'));
    		}
    		
    		/* @var $group Mage_Customer_Model_Group */
    		$group = Mage::getModel('customer/group')->load($existingItem->getCustomerGroupId());
    		
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
    		$msg = Mage::helper('egovsvies')->__(
    				'Item with the same country %s, company %s and Vat %s condition already assigned to customer group %s (ID: %s)!',
    				$locale->getCountryTranslation($item->getCountryId()),
    				$group->getCompany(),
    				$yesnocustom,
    				$group->getCustomerGroupCode(),
    				$group->getCustomerGroupId()    				
    		);
    		throw new Egovs_Vies_Model_Resource_Exception_Duplicate($msg);
    				
    	}
    }
}
