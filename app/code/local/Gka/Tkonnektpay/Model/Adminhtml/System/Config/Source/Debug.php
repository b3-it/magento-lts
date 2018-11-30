<?php
/**
 * Source für DEBUG Level
 *
 * @category   	Gka
 * @package    	Gka_Tkonnketpay
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 *
 * @see Mage_Adminhtml_Model_System_Config_Source_Order_Status
 */
class Gka_Tkonnektpay_Model_Adminhtml_System_Config_Source_Debug
{
	/**
	 * Liefert ein Array der möglichen Optionen
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		return array(
			array('value'=>Egovs_Paymentbase_Model_Tkonnekt::TKONNEKT_DEBUG_OFF, 'label'=>Mage::helper('gka_tkonnektpay')->__('Debug Off')),
			array('value'=>Egovs_Paymentbase_Model_Tkonnekt::TKONNEKT_DEBUG_ON, 'label'=>Mage::helper('gka_tkonnektpay')->__('Debug On')),
			array('value'=>Egovs_Paymentbase_Model_Tkonnekt::TKONNEKT_DEBUG_ON_EPAYBL_OFF, 'label'=>Mage::helper('gka_tkonnektpay')->__('Debug On ePayBL Off')),
		);
	}
}