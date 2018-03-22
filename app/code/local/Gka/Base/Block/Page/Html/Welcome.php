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
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Page
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Html page block
 *
 * @category   Mage
 * @package    Mage_Page
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Gka_Base_Block_Page_Html_Welcome  extends Mage_Page_Block_Html_Welcome
{
  
	/**
	 * aktuelles Datum als String
	 * @return string
	 */
	protected function _getDate()
	{
		$format = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
		$date =  Mage::app()->getLocale()->date();
		return $date->toString($format);
	}
	
	
	/**
	 * Name des aktuellen Stores
	 * @return string|NULL
	 */
	protected function getStore()
	{
		return Mage::app()->getStore()->getName();
	}
	
    /**
     * Get block message
     *
     * @return string
     */
    protected function _toHtml()
    {
    	$date = $this->_getDate();
        if (empty($this->_data['welcome'])) {
            if (Mage::isInstalled() && $this->_getSession()->isLoggedIn()) {
            	$customer = Mage::getSingleton('customer/session')->getCustomer();
                $this->_data['welcome'] =  $this->__('You are logged in as %s in %s <span>%s</span>',
     					                            $this->escapeHtml($customer->getName()),
     					                            $this->escapeHtml($this->getStore()),
                									$date
     					                           );
            } else {
                $this->_data['welcome'] = Mage::getStoreConfig('design/header/welcome');
            }
        }

        return $this->_data['welcome'];
    }

  
}