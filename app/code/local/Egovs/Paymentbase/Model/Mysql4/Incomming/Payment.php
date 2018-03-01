<?php
/**
 * Resource Model für Zahlungseingönge
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @name       	Egovs_Paymentbase_Model_Mysql4_Incomming_Payment
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Mysql4_Incomming_Payment extends Mage_Core_Model_Mysql4_Abstract
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
        $this->_init('paymentbase/incomming_payment', 'id');
    }
}