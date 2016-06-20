<?php
/**
 * Egovs EventBundle
 *
 *
 * @category   	Egovs
 * @package    	Egovs_EventBundle
 * @name       	Egovs_EventBundle_Model_Resource_SalesQuoteItemPersonal
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Model_Resource_Sales_Quote_Item_Personal extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the eventbundle_salesquoteitempersonal_id refers to the key field in your database table.
        $this->_init('eventbundle/quote_options', 'id');
    }
}
