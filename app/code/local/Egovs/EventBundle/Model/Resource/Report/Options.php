<?php
/**
 *
 * Product options reports RecourceModel
 *
 * @category   TuFreiberg
 * @package    TuFreiberg_TufReports
 */
class Egovs_EventBundle_Model_Ressource_Report_Options extends Mage_Core_Model_Mysql4_Abstract//Mage_Sales_Model_Entity_Order_Invoice_Item
{
	protected function  _construct()
    {
        $this->_init('sales/order_item', 'item_id');
    }
}