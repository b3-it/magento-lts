<?php
/**
 * Slpb Customer
 * 
 * 
 * @category   	Slpb
 * @package    	Slpb_Customer
 * @name       	Slpb_Customer_Model_Mysql4_Sales
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Slpb_Customer_Model_Mysql4_Sales extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the customer_sales_id refers to the key field in your database table.
        $this->_init('customer/sales', 'customer_sales_id');
    }
}