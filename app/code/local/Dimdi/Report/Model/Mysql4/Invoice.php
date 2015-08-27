<?php
/**
 * Dimdi Report
 *
 *
 * @category   	Dimdi
 * @package    	Dimdi_Report
 * @name        Dimdi_Report_Model_Mysql4_Invoice
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dimdi_Report_Model_Mysql4_Invoice extends Mage_Sales_Model_Resource_Order_Invoice_Item
{
	public function x_construct()
	{
		$this->_init('dimdireport/invoice', 'entity_id');
	}
}