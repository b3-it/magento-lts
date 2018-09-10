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
class Egovs_Paymentbase_Model_System_Config_Backend_Epayblcert extends Egovs_Paymentbase_Model_System_Config_Backend_Abstract_Data
{
	/**
	 * Validierung des Zertifkatpfads
	 * 
	 * @return Egovs_Paymentbase_Model_System_Config_Backend_Epayblcert
	 * 
	 * @see Mage_Core_Model_Abstract::_beforeSave()
	 */
    protected function _beforeSave()
    {
    	parent::_beforeSave();
    	
    	$value = $this->getValue();
        
        if (strpos($value, '../') !== false) {
        	Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('The %s you entered is invalid. Relative paths with .. are not allowed!', $this->getFieldConfig()->label));
        	$value = null;
        }
        
        if (!isset($value) || strlen($value) < 1) {
        	$this->setValue($value);
        	return $this;
        }
        	
        if (!file_exists(Mage::getBaseDir().$value)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('The %s you entered is invalid. Please make sure that the certificate exists.', $this->getFieldConfig()->label));
            $value = null;
        }

        $this->setValue($value);
        return $this;
    }
}
