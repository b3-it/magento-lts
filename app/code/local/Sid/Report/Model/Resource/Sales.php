<?php
/**
 * ResourceModel für Verkaufte Produkte
 *
 * @category   	Sid
 * @package    	Sid_Report
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Report_Model_Resource_Sales extends Mage_Core_Model_Resource_Db_Abstract
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