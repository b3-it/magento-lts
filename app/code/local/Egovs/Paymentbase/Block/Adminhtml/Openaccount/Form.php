<?php
/**
 * Basis-Form-Block für Bestellungen
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Openaccount_Form extends Mage_Core_Block_Template
{
    /**
     * Retrieve payment method model
     *
     * @return Mage_Payment_Model_Method_Abstract
     */
    public function xxgetMethod()
    {
        $method = $this->getData('method');

        if (!($method instanceof Mage_Payment_Model_Method_Abstract)) {
            Mage::throwException($this->__('Can not retrieve payment method model object.'));
        }
        return $method;
    }

    /**
     * Retrieve payment method code
     *
     * @return string
     */
    public function xxgetMethodCode()
    {
        return $this->getMethod()->getCode();
    }

    /**
     * Retrieve field value data from payment info object
     *
     * @param string $field Feld
     * 
     * @return  mixed
     */
    public function xxgetInfoData($field)
    {
        return $this->htmlEscape($this->getMethod()->getInfoInstance()->getData($field));
    }
    
    public function getPeriod()
    {
    	
    }
}