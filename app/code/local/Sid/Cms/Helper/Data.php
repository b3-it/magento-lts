<?php
/**
 * Sid Cms
 * 
 * 
 * @category   	Sid
 * @package    	Sid_Cms
 * @name       	Sid_Cms_Helper_Data
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Helper_Data extends Mage_Core_Helper_Abstract
{
		
		public function isPageAllowed($page)
		{
			$customergroups_hide = $page->getData('customergroups_hide');
			$found = in_array($this->getCustomerGroupId(), $customergroups_hide);
			return !$found;
		}
		
 	/**
     * Return the customer id of the current customer
     *
     * @return int
     */
    public function getCustomerGroupId()
    {
        return Mage::getSingleton('customer/session')->getCustomerGroupId();
    }
}