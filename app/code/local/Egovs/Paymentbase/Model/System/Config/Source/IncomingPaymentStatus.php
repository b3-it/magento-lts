<?php
/**
 * Liefert eine Liste aller verfügbaren Versionen
 *
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2018 B3 IT Systeme GmbH https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Paymentbase_Model_System_Config_Source_IncomingPaymentStatus
{

    /**
     * Liefert ein Array der möglichen Optionen
     *
     * @return array
     */
    public function toOptionArray() {

        $status = array(
            array('value'=>'', 'label'=>Mage::helper('paymentbase')->__('Select an entry...')),
        );
        $status[] = array('value' => Egovs_Paymentbase_Model_Paymentbase::KASSENZEICHEN_STATUS_NEW, 'label' => Mage::helper('paymentbase')->__('New'));
        $status[] = array('value' => Egovs_Paymentbase_Model_Paymentbase::KASSENZEICHEN_STATUS_PROCESSING, 'label' => Mage::helper('paymentbase')->__('Processing'));
        $status[] = array('value' => Egovs_Paymentbase_Model_Paymentbase::KASSENZEICHEN_STATUS_COMPLETE, 'label' => Mage::helper('paymentbase')->__('Complete'));
        $status[] = array('value' => Egovs_Paymentbase_Model_Paymentbase::KASSENZEICHEN_STATUS_ERROR, 'label' => Mage::helper('paymentbase')->__('Error'));

        return $status;
    }

    public function toArray() {
        $options = array();
        $optionArray = $this->toOptionArray();
        array_shift($optionArray);
        foreach ($optionArray as $option) {
            $options[$option['value']] = $option['label'];
        }

        return $options;
    }
}