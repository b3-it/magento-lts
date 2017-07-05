<?php
/**
 * Html page block Welcome
 *
 * Template wird im Layout gesetzt!
 * https://magento.stackexchange.com/questions/30385/how-do-i-change-the-welcome-message-in-magento-1-9-the-proper-way
 *
 * @category   	Gka
 * @package    	Gka_Base
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3-IT Systeme GmbH - http://www.b3.it.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @see Mage_Payment_Block_Form
 */

class Gka_Base_Block_Page_Html_Header extends Mage_Page_Block_Html_Welcome
{
	/**
	 * Get block messsage
	 *
	 * @return string
	 */
	protected function _toHtml() {
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

     /**
      * Get tags array for saving cache
      *
      * @return array
      */
     public function getCacheTags()
     {
     	if (Mage::getSingleton('customer/session')->isLoggedIn()) {
     		$this->addModelTags(Mage::getSingleton('customer/session')->getCustomer());
     	}
     	
     	return parent::getCacheTags();
     }
}
