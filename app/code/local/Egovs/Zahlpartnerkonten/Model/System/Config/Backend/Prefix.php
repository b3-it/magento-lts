<?php
/**
 * Prüft ob ePayBL erreicht werden kann.
 *
 * @category   	Egovs
 * @package    	Egovs_Zahlpartnerkonten
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de 
 * @license    	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Zahlpartnerkonten_Model_System_Config_Backend_Prefix extends Mage_Core_Model_Config_Data
{
	/**
	 * Prüft ob ePayBL erreicht werden kann
	 * 
	 * @return Egovs_Paymentbase_Model_System_Config_Backend_Alive
	 * 
	 * @see Mage_Core_Model_Abstract::_beforeSave()
	 */
    protected function _beforeSave() {
        $prefix = $this->getValue();

        //Auf Ganzzahl prüfen
        if (!is_numeric($prefix) || $prefix != round($prefix)) {
        	Mage::throwException(Mage::helper('zpkonten')->__('The Mandantenprefix have to be numeric!'));
        }
        
        $length = (int) $this->getFieldsetDataValue('zpkonten_length');
         
        if (strlen($prefix) >= intval($length)) {
        	Mage::throwException(Mage::helper('zpkonten')->__('Prefix is too long.'));
        }
        
        return $this;
    }
}
