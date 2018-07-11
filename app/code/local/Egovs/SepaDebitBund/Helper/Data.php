<?php
/**
 * Helper
 *
 * @category	Egovs
 * @package		Egovs_SepaDebitBund
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2013-2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_SepaDebitBund_Helper_Data extends Egovs_Paymentbase_Helper_Data
{
    public function getSequenceTypeForMultiUsage() {
        $sepaVersion = Mage::getStoreConfig('payment/sepadebitbund/sepa_version');
        if ($sepaVersion >= 30) {
            //> SEPA 3.0
            return Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_RCUR;
        }
        return Egovs_Paymentbase_Model_Webservice_Types_SepaMandat::SEQUENCE_TYPE_FRST;
    }
}