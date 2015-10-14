<?php

class Egovs_GermanTax_Block_Checkout_Multipage_Overview extends Egovs_Checkout_Block_Multipage_Overview
{
	public function getBaseAddress()
	{
		
		return $this->getCheckout()->getQuote()->getBaseAddress();
	}
}
