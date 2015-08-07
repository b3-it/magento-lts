<?php
/**
 * Resource Model für Haushaltsparameter Objektnummern.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Mysql4_Haushaltsparameter_Objektnummerhhstelle extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 */
    protected function _construct() {
        // Note that the paymentbase_haushaltsparameter_id refers to the key field in your database table.
        $this->_init('paymentbase/haushaltsparameter_objektnummerhhstelle', 'paymentbase_objektnummer_hhstelle_id');
    }
}