<?php
/**
 * Resource Model zur Rerwaltung der Mandats History
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Mysql4_Sepa_Mandate_History extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 */
    protected function _construct() {
        // Note that the paymentbase_defineparams_id refers to the key field in your database table.
        $this->_init('paymentbase/sepa_mandate_history', 'entity_id');
    }
}