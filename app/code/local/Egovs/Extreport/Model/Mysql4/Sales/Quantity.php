<?php
/**
 * ResourceModel für Verkaufte Produkte
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Sales_Quantity extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * Initialisierung mit eigenem Resource Model
	 *
	 * @return void
	 *
	 * @see Varien_Object::_construct()
	 */
 	protected function _construct() {
         $this->_init('sales/order_item', 'item_id');
    }
}