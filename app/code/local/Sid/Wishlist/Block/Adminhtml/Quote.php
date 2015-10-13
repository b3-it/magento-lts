<?php
/**
 * Block für Quotes im BE
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Block_Adminhtml_Quote extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct() {
		$this->_controller = 'adminhtml_quote';
		$this->_blockGroup = 'sidwishlist';
		$this->_headerText = Mage::helper('sidwishlist')->__('Item Manager');
		$this->_addButtonLabel = Mage::helper('sidwishlist')->__('Add Item');
		parent::__construct();
	}
}