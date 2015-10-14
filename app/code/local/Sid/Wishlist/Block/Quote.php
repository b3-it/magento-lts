<?php
/**
 * Block für Quotes
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Block_Quote extends Mage_Core_Block_Template
{
	/**
	 * Initialisiert das Layout
	 * 
	 * @return Sid_Wishlist_Block_Adminhtml_Quote
	 * 
	 * @see Mage_Core_Block_Abstract::_prepareLayout()
	 */
	protected function _prepareLayout() {
		return parent::_prepareLayout();
    }
    
    public function getWishlist() { 
        if (!$this->hasData('quote')) {
            $this->setData('quote', Mage::registry('quote'));
        }
        return $this->getData('quote');
        
    }
}