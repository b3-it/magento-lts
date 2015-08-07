<?php
/**
 * Resource Collection für Mandats History.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Mysql4_Sepa_Mandate_History_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	/**
	 * Konstruktor
	 *
	 * @return void
	 *
	 * @see Mage_Core_Model_Resource_Db_Collection_Abstract::_construct()
	 */
    protected function _construct() {
        parent::_construct();
        $this->_init('paymentbase/sepa_mandate_history');
    }
}