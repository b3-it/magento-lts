<?php
/**
 * Formblock für Kreditkarte über Saferpay
 *
 * Setzt ein eigenes Template
 *
 * @category   	Egovs
 * @package    	Egovs_Saferpay
 * @name       	Egovs_Saferpay_Block_Form
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author		René Sieberg <rsieberg@web.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Saferpay_Block_Form extends Mage_Payment_Block_Form
{
	/**
	 * Setzt ein eigenes Template
	 *
	 * @return void
	 *
	 * @see Mage_Core_Block_Abstract::_construct()
	 */
	protected function _construct() {

		parent::_construct();
	}
}