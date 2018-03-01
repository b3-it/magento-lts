<?php
/**
 * Resource Model für Zahlungseingönge
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @name       	Egovs_Paymentbase_Model_Mysql4_Incoming_Payment
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Mysql4_Incoming_Payment extends Mage_Core_Model_Mysql4_Abstract
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
        $this->_init('paymentbase/incoming_payment', 'id');
    }

    public function saveIncomingPayment($object,$order_id,$base_amount, $amount )
    {
        $order_id = intval($order_id);
        $amount = floatval($amount);
        $base_amount = floatval($base_amount);
        //insert into egovs_paymentbase_incoming_payment (order_id, total_paid, base_total_paid, epaybl_capture_date)
       // (select 1,  sum(total_paid) - 3, sum(base_total_paid) - 3 , now() from egovs_paymentbase_incoming_payment where order_id = 1)
        $sql = "INSERT INTO {$this->getMainTable()} (order_id, total_paid, base_total_paid, paid, base_paid,  epaybl_capture_date) ";
        $sql .= "(SELECT {$order_id}, {$amount},{$base_amount}, IFNULL({$amount} - sum(paid),{$amount}), IFNULL({$base_amount} - sum(base_paid),{$base_amount}) , now() FROM {$this->getMainTable()} WHERE order_id = {$order_id})";
        $this->_getWriteAdapter()->query($sql);
    }
}