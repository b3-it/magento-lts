<?php
/**
 * Source für Typ der SEPA Mandatsverwaltung
 *
 * @category	Egovs
 * @package		Egovs_SepaDebitBund
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2013-2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_SepaDebitBund_Model_Adminhtml_System_Config_Source_Version
{
    public function toOptionArray()
    {
        $options = array();
        $options[] = array('value' => 20, 'label'=>Mage::helper('paymentbase')->__('SEPA 2.x'));
        $options[] = array('value' => 30, 'label'=>Mage::helper('paymentbase')->__('SEPA 3.x'));

        return $options;
    }
}
