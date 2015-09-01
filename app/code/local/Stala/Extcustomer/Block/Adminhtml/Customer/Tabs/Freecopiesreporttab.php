<?php
/**
 * Adminhtml customer freecopies abo overview block
 *
 * @category	Stala
 * @package 	Stala_Extcustomer
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel (http://www.edv-beratung-hempel.de)
 * @copyright	Copyright (c) 2011 TRW-NET (http://www.trw-net.de)
 */
class Stala_Extcustomer_Block_Adminhtml_Customer_Tabs_Freecopiesreporttab extends Stala_Extcustomer_Block_Adminhtml_Customer_Tabs_Freecopiestab
{
	/**
     * Retrieve Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('extcustomer')->__('Freecopies Abo Overview');
    }

    /**
     * Retrieve Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('extcustomer')->__('Freecopies Abo Overview');
    }
    
    public function getTabUrl() {
    	return $this->getUrl('adminhtml/extcustomer_customer_freecopies/report', array('_current' => true,'customer_id'=>Mage::registry('current_customer')->getId()));
    }	
}
