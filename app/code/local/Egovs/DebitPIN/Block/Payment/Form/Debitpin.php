<?php
/**
* Formblock für Lastschriftzahlungen mit PIN
*
* Setzt ein eigenes Template
*
* @category   	Egovs
* @package    	Egovs_DebitPIN
* @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
* @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
* @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de* 
* @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
*
* @see Mage_Payment_Block_Form
*/
class Egovs_DebitPIN_Block_Payment_Form_Debitpin extends Mage_Payment_Block_Form_Cc
{
	/**
	 * Setzt ein eigenes Template
	 * 
	 * @return void
	 * @see Mage_Payment_Block_Form_Cc::_construct()
	 */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('egovs/debitpin/payment/form/debitpin.phtml');
    }    
}
