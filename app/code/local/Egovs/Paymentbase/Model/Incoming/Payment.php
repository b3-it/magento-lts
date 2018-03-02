<?php
/**
 * Klasse zum Regisrtieren zun Zahlungseingängen
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @name       	Egovs_Paymentbase_Model_Incoming_Payment
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2018 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Incoming_Payment extends Mage_Core_Model_Abstract
{
	 public function _construct()
    {
        parent::_construct();
        $this->_init('paymentbase/incoming_payment');
    }

    public function saveIncomingPayment($order_id, $base_amount, $amount)
    {
        $this->getResource()->saveIncomingPayment($this, $order_id, $base_amount, $amount);
    }
}