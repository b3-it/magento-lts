<?php
/**
 * SEPA Debit Bund Mandate
 *
 * @category	Egovs
 * @package		Egovs_SepaDebitBund
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2013-2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_SepaDebitBund_Model_Sepa_Mandate extends Egovs_Paymentbase_Model_Sepa_Mandate
{
	public function getSequenceTypeForMultiUsage() {
        return Mage::helper('sepadebitbund')->getSequenceTypeForMultiUsage();
    }
}