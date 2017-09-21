<?php

/**
 * Infoblock für Zahlungen per Vorkasse
 *
 * @category   	Egovs
 * @package    	Egovs_BankPayment
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2011-2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @see Mage_Payment_Block_Info
 */
class Gka_Barkasse_Block_Info extends Mage_Payment_Block_Info
{
	/**
	 * Überschreibt das Template
	 * 
	 * @return void
	 * 
	 * @see Mage_Payment_Block_Info::_construct()
	 */
    protected function _construct() {
        parent::_construct();
        //$this->setTemplate('egovs/bankpayment/info.phtml');
    }
    
 
}
