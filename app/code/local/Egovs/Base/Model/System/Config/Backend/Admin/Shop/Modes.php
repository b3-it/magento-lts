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
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Admin Reset Password Link Expiration period backend model
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Base_Model_System_Config_Backend_Admin_Shop_Modes extends Mage_Core_Model_Config_Data
{
    /**
     * Validate expiration period value before saving
     *
     * @return Mage_Adminhtml_Model_System_Config_Backend_Admin_Password_Link_Expirationperiod
     */
    protected function _beforeSave()
    {
        parent::_beforeSave();
        $mode = (int) $this->getValue();
        // This value must be greater than 0
        if ($mode < 1) {
            $mode = (int) $this->getOldValue();
        }
        Mage::getConfig()->saveConfig('admin/design/mode_default', 0);
        Mage::getConfig()->saveConfig('admin/design/mode_test', 0);
        Mage::getConfig()->saveConfig('admin/design/mode_migration', 0);
        Mage::getConfig()->saveConfig('admin/design/mode_int', 0);
        Mage::getConfig()->saveConfig('admin/design/mode_prod', 0);
        switch ($mode) {
        	case 1:
        		//Test
        		Mage::getConfig()->saveConfig('admin/design/mode_test', 1);
        		break;
        	case 2:
        		//Int
        		Mage::getConfig()->saveConfig('admin/design/mode_int', 1);
        		break;
        	case 3:
        		//Prod
        		Mage::getConfig()->saveConfig('admin/design/mode_prod', 1);
        		break;
        	case 4:
        	    //Migration
        	    Mage::getConfig()->saveConfig('admin/design/mode_migration', 1);
        	    break;
        	case 0:
        	default:
        		//Not Specified
        		Mage::getConfig()->saveConfig('admin/design/mode_default', 1);
        }
        $this->setValue($mode);
        return $this;
    }
}
