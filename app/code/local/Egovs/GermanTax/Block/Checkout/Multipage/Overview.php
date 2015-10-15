<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Block_Checkout_Multipage_Overview extends Egovs_Checkout_Block_Multipage_Overview
{
	public function getBaseAddress()
	{
		
		return $this->getCheckout()->getQuote()->getBaseAddress();
	}
}
