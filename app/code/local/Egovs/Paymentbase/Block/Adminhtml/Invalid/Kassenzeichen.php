<?php
/**
 * Block für invalide Kassenzeichen
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Invalid_Kassenzeichen extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
	public function __construct() {
		$this->_controller = 'adminhtml_invalid_kassenzeichen';
		$this->_blockGroup = 'paymentbase';
		$this->_headerText = Mage::helper('paymentbase')->__('Invalid Kassenzeichen');
		parent::__construct();
	}

	/**
	 * Layout anpassen
	 * 
	 * @return void
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Grid_Container::_prepareLayout()
	 */
	protected function _prepareLayout()	{
		parent::_prepareLayout();
		$this->removeButton('add');
	}
}