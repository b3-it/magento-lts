<?php
/**
 * Klasse zum Regisrtieren zun Zahlungseingängen
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @name       	Egovs_Paymentbase_Model_Incomming_Payment
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_Incomming_Payment extends Mage_Core_Model_Abstract
{
	 public function _construct()
    {
        parent::_construct();
        $this->_init('paymentbase/incomming_payment');
    }
}