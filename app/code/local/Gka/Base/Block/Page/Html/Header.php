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
 * @category   Mage
 * @package    Mage_Page
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Html page block
 *
 * Template wird im Layout gesetzt!
 *
 * @category   Mage
 * @package    Mage_Page
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Gka_Base_Block_Page_Html_Header extends Mage_Page_Block_Html_Welcome
{
     public function getWelcome() {
var_dump(1);
     	if (empty($this->_data['welcome'])) {
     		if (Mage::isInstalled() && Mage::getSingleton('customer/session')->isLoggedIn()) {
     			$customer = Mage::getSingleton('customer/session')->getCustomer();

     			$this->_data['welcome'] = $this->__('You are logged in as %s in %s',
     					                            $this->escapeHtml($customer->getName()),
     					                            $this->escapeHtml(Mage::app()->getStore()->getName())
     					                           );
     		} else {
     			$this->_data['welcome'] = Mage::getStoreConfig('design/header/welcome');
     		}
     	}

     	return $this->_data['welcome'];
     }
     
}
