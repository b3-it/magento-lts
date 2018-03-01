<?php
/**
 * Resource Collection für Zahlungseingänge
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @name       	Egovs_Paymentbase_Model_Mysql4_Incomming_Payment_Collection
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Mysql4_Incomming_Payment_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
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
        $this->_init('paymentbase/incomming_payment');
    }
}