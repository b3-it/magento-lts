<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Model_Mysql4_Invoice
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Model_Mysql4_Invoice extends Mage_Sales_Model_Resource_Order_Invoice_Item
{
    public function x_construct()
    {    
        // Note that the ibewi_access_id refers to the key field in your database table.
        $this->_init('ibewi/invoice', 'ibewi_access_id');
    }
}