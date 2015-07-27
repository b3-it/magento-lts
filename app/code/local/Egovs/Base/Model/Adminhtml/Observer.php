<?php

/**
 * Observer f�r von Kundenoperationen ausgel�sten Events
 *
 * @category   	Egovs
 * @package    	Egovs_Base
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 - 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class Egovs_Base_Model_Adminhtml_Observer
{
	/**
	 * Block
	 * 
	 * @var Mage_Core_Block_Abstract
	 */
	protected $_block = null;
	
	/**
	 * Wird beim Erzeugen eines Blocks aufgerufen
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function onCoreLayoutBlockCreateAfter($observer) {
		$block = $observer->getBlock();
		
		if (!$block) {
			$this->_block = null;
			return;
		}
		
		$this->_block = $block;
		
		if ($block instanceof Mage_Adminhtml_Block_Customer_Edit_Tab_Addresses) {
			$this->_processCustomerAddressesBlock();
		}
	}
	
	/**
	 * Setzt das Template für Mage_Adminhtml_Block_Customer_Edit_Tab_Addresses
	 * 
	 * @return Egovs_Base_Model_Adminhtml_Observer
	 */
	protected function _processCustomerAddressesBlock() {
		if (!($this->_block instanceof Mage_Adminhtml_Block_Customer_Edit_Tab_Addresses)) {
			return $this;
		}
		
		$this->_block->setTemplate('egovs/customer/tab/addresses.phtml');
		
		return $this;
	}
}