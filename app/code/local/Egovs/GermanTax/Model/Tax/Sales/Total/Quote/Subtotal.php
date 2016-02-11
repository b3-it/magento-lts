<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Model_Tax_Sales_Total_Quote_Subtotal extends Mage_Tax_Model_Sales_Total_Quote_Subtotal
{
	/**
	 * Class constructor
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->_calculator  = Mage::getSingleton('germantax/tax_calculation');
	}
	
	/**
	 * Caclulate item price and row total with configured rounding level
	 *
	 * @param Mage_Sales_Model_Quote_Address $address
	 * @param Mage_Sales_Model_Quote_Item_Abstract $item
	 * @return Mage_Tax_Model_Sales_Total_Quote_Subtotal
	 */
	protected function _processItem($item, $taxRequest)
	{
		$taxRequest->setIsVirtual($item->getIsVirtual());
		 
		return parent::_processItem($item, $taxRequest);
	}
}