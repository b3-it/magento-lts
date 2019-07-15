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

//        $sql = "INSERT INTO {$this->getMainTable()} (order_id, total_paid, base_total_paid, paid, base_paid, epaybl_capture_date, message) ";
//        $sql .= '(';
//        $sql .= "SELECT {$order_id}, {$amount}, {$base_amount}, IFNULL({$amount} - sum(paid), {$amount}), IFNULL({$base_amount} - sum(base_paid), {$base_amount}), UTC_TIMESTAMP(), '{$msg}'";
//        $sql .= " FROM {$this->getMainTable()}";
//        $sql .= " WHERE order_id = {$order_id}";
//        $sql .= " HAVING (IFNULL({$base_amount} - sum(base_paid), {$base_amount}) > 0.00) OR {$force}=1";
//        $sql .= ')';


        /** @noinspection SqlResolve */
        $sql = sprintf(
            'INSERT INTO %s (order_id, total_paid, base_total_paid, epaybl_capture_date, message) VALUES (%s);'
            , $this->getMainTable()
            , "{$order_id}, {$amount}, {$base_amount}, UTC_TIMESTAMP(), '{$msg}'"
        );
        $this->_getWriteAdapter()->query($sql);
    }

    public function calculatePaidAmound($object)
    {
        $order_id = (int)$object->getOrderId();
        $total = (float)$object->getTotalPaid();
        $baseTotal = (float)$object->getBaseTotalPaid();

        $sql = "SELECT sum(paid) as p, sum(base_paid) as bp";
        $sql .= " FROM {$this->getMainTable()}";
        $sql .= " WHERE order_id = {$order_id} AND paid is NOT NULL;";

        $res = $this->_getReadAdapter()->fetchRow($sql);
        if(is_array($res))
        {
            $total -= (float) isset($res['p']) ? $res['p'] : 0;
            $baseTotal -= (float) isset($res['bp']) ? $res['bp'] : 0;
            $total = max(0, $total);
            $baseTotal = max(0, $baseTotal);
        }
        $object->setPaid($total);
        $object->setBasePaid($baseTotal);
    }

}