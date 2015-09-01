<?php
/**
 * Kunden Guthaben Rendererklasse
 *
 * @category    Stala
 * @package     Stala_Extcustomer
 * @author      Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Stala_Extcustomer_Block_Adminhtml_Customer_Edit_Renderer_Discount extends Varien_Data_Form_Element_Text
{
	public function getHtml() {
        
		/* @var $salesDiscount Stala_Extcustomer_Model_Salesdiscount */
		$salesDiscount = Mage::getModel('extcustomer/salesdiscount');
		$abandoned = $salesDiscount->getAbandonedDiscountQuota(Mage::registry('current_customer'));
		$abandoned = Mage_Core_Helper_Data::currency($abandoned, true, false);
		$this->setNote(Mage::helper('extcustomer')->__('Current abandoned discount quota: %s', $abandoned));
    	
        return parent::getHtml();
    }
}