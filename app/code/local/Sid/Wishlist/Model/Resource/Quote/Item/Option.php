<?php
/**
 * Quote Item Option - Model
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Resource_Quote_Item_Option extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Main table und Field Initialisierung
     * 
     * @return void
     */
    protected function _construct() {
        $this->_init('sidwishlist/quote_item_option', 'option_id');
    }
}
