<?php

class Egovs_Shipment_Block_Cart_Estimate extends Egovs_Shipment_Block_Cart_Shipping //Mage_Checkout_Block_Cart_Abstract
{
	protected function _construct()
	{
		parent::_construct();
			$this->setTemplate('egovs/shippment/cart/estimaterates.phtml');
		
	}
}
