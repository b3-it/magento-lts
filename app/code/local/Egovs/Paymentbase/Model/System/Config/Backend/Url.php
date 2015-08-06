<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de 
 * @license    	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Egovs_Paymentbase_Model_System_Config_Backend_Url extends Egovs_Paymentbase_Model_System_Config_Backend_Abstract_Data
{
	/**
	 * Validierung der URL
	 * 
	 * @return Egovs_Paymentbase_Model_System_Config_Backend_Url
	 * 
	 * @see Mage_Core_Model_Abstract::_beforeSave()
	 */
    protected function _beforeSave()
    {
    	parent::_beforeSave();
    	
        $value = $this->getValue();
        
        $groups = $this->getGroups();
        
        $fieldGroup = null;
        if (is_array($groups) && key_exists($this->getGroupId(), $groups)) {
        	$group = $groups[$this->getGroupId()];
        	if (is_array($group)) {
        		if (key_exists('fields', $group)) {
	        		$fields = $group['fields'];
		
		        	if (is_array($fields))
		        		$fieldGroup = $fields;
        		}
        	}
        }
        
        if ($this->getGroupId() != 'paymentbase' && $this->getField() != 'service') {
        	$active = (bool) Mage::getStoreConfig ( sprintf('payment/%s/active', $this->getGroupId()) );
	        if ($fieldGroup && key_exists('active', $fieldGroup)) {
	        	$active = $fieldGroup['active'];
	        	$active = (bool) $active['value'];
	        }
        
	        if (!$active && (!isset($value) || strlen($value) < 1)) {
	        	$this->setValue($value);
	        	return $this;
	        }
        } else {
        	if ($fieldGroup && key_exists('mandantnr', $fieldGroup)) {
        		$mandant = $fieldGroup['mandantnr'];
        		$mandant = (string) $mandant['value'];
        	}
        	
        	//bewirtschafternr
        	if ($fieldGroup && key_exists('bewirtschafternr', $fieldGroup)) {
        		$bewirtschafter = $fieldGroup['bewirtschafternr'];
        		$bewirtschafter = (string) $bewirtschafter['value'];
        	}
        	
        	if (empty($mandant) && empty($bewirtschafter) && (!isset($value) || strlen($value) < 1)) {
        		$this->setValue($value);
        		return $this;
        	}
        }
        	
        //Falls mit Platzhaltern gearbeitet wird
        if (!preg_match('#^{{((un)?secure_)?base_url}}#', $value)) {
            $parsedUrl = parse_url($value);
            if (!isset($parsedUrl['scheme']) || (!isset($parsedUrl['host']) && !isset($parsedUrl['path']))) {
                Mage::throwException(Mage::helper('core')->__('The %s you entered is invalid. Please make sure that it follows "http://domain.com/" format.', $this->getFieldConfig()->label));
            }
        }

        $value = rtrim($value,  '/');
        /**
         * If value is special ({{}}) we don't need add slash
         */
        /*
        if (!preg_match('#}}$#', $value)) {
        	$value.= '/';
        } */
         

        $this->setValue($value);
        return $this;
    }
}
