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
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 IT Systeme GmbH - http://www.b3-it.de 
 * @license    	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Egovs_Paymentbase_Model_System_Config_Backend_Abstract_Data extends Mage_Core_Model_Config_Data
{
	/**
	 * Before Save
	 * 
	 * @return Egovs_Paymentbase_Model_System_Config_Backend_Abstract_Data
	 * 
	 * @see Mage_Core_Model_Abstract::_beforeSave()
	 */
    protected function _beforeSave()
    {
    	parent::_beforeSave();
    	
    	if (!Mage::helper('paymentbase/validation')->isAllowed($this->getFieldConfig())) {
    		$this->_dataSaveAllowed = false;
    	}
    	
        return $this;
    }
}
