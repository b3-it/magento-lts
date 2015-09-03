<?php
/**
 * Slpb Customer
 * 
 * 
 * @category   	Slpb
 * @package    	Slpb_Customer
 * @name       	Slpb_Customer_Model_Mysql4_Sales_Collection
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Slpb_Customer_Model_Mysql4_Sales_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customer/sales');
    }
}