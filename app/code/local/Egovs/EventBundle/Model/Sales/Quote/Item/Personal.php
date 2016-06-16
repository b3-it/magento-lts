<?php
/**
 * Egovs EventBundle
 *
 *
 * @category   	Egovs
 * @package    	Egovs_EventBundle
 * @name       	Egovs_EventBundle_Model_SalesQuoteItemPersonal
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Model_Sales_Quote_Item_Personal extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventbundle/sales_quote_item_personal');
    }
    
    
    public function saveQuote($quoteId, $PersonalOptions)
    {
    	
    }
}
