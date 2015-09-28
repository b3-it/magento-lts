<?php

/**
 * Formblock für Lastschriftzahlungen
 *
 * Setzt ein eigenes Template
 *
 * @category   	Egovs
 * @package    	Egovs_Debit
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Payment_Block_Form
 */
class Egovs_Debit_Block_Form extends Mage_Payment_Block_Form
{
	/**
	 * Setzt ein eigenes Template
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Block_Abstract::_construct()
	 */
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('egovs/debit/form.phtml');
	}
}
