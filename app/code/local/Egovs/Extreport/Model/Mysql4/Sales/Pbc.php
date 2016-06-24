<?php
/**
 *
 * Produkte nach Kunden ResourceModel
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Sales_Pbc extends Mage_Core_Model_Mysql4_Abstract
{	
 	public function _construct()
    {    	
         $this->_init('sales/order_item', 'item_id');
    }
}