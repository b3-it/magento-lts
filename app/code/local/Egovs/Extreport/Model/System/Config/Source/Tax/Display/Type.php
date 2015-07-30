<?php
/**
 * Anzeige für Netto-/Bruttopreise
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_System_Config_Source_Tax_Display_Type extends Mage_Tax_Model_System_Config_Source_Tax_Display_Type
{
    public function toOptionArray() {
    	$_options = parent::toOptionArray();
    	$n = count($_options);
    	
    	if ($n - 1 > 0) {
    		unset($_options[$n-1]);
    	}
    	
        return $_options;
    }
}
