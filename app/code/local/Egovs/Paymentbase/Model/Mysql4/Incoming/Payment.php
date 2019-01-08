<?php
/**
 * Resource Model für Zahlungseingönge
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @name       	Egovs_Paymentbase_Model_Mysql4_Incoming_Payment
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @author      Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2018 B3 It Systeme GmbH - http://www.b3-it.de
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

    public function saveIncomingPayment($object, $order_id, $base_amount, $amount, $msg = null, $force = false)
    {
        $order_id = (int)$order_id;
        $amount = (float)$amount;
        $base_amount = (float)$base_amount;
        $force = (int)$force;
        /*
         * set @base_amount = 10.52;
         * set @amount = @base_amount;
         * set @order_id = 61;
         * INSERT INTO magento19.egovs_paymentbase_incoming_payment (order_id, total_paid, base_total_paid, paid, base_paid,  epaybl_capture_date)
         * (
         *     SELECT @order_id, @amount, @base_amount, IFNULL(@amount - sum(paid),@amount), IFNULL(@base_amount - sum(base_paid),@base_amount) , UTC_TIMESTAMP()
         *     FROM magento19.egovs_paymentbase_incoming_payment as t
         *     WHERE order_id = @order_id
         *     HAVING (IFNULL(@base_amount - sum(base_paid), @base_amount) > 0.00)
         * )
         */
        $sql = "INSERT INTO {$this->getMainTable()} (order_id, total_paid, base_total_paid, paid, base_paid, epaybl_capture_date, message) ";
        $sql .= '(';
        $sql .= "SELECT {$order_id}, {$amount}, {$base_amount}, IFNULL({$amount} - sum(paid), {$amount}), IFNULL({$base_amount} - sum(base_paid), {$base_amount}), UTC_TIMESTAMP(), '{$msg}'";
        $sql .= " FROM {$this->getMainTable()}";
        $sql .= " WHERE order_id = {$order_id}";
        $sql .= " HAVING (IFNULL({$base_amount} - sum(base_paid), {$base_amount}) > 0.00) OR {$force}=1";
        $sql .= ')';
        $this->_getWriteAdapter()->query($sql);
    }
}