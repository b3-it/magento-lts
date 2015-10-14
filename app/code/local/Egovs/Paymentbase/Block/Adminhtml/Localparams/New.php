<?php
/**
 * Block zum erzeugen von Buchungslistenparametern
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Localparams_New extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct() {
		parent::__construct();
		 
		$this->_objectId = 'id';
		$this->_blockGroup = 'paymentbase';
		$this->_controller = 'adminhtml_localparams';
		$this->_mode = 'new';

		$this->_updateButton('save', 'label', Mage::helper('paymentbase')->__('Save Parameter'));
	}

	protected function _prepareLayout() {
		parent::_prepareLayout();
		 
		return $this;
	}

	public function getHeaderText() {

		return Mage::helper('paymentbase')->__('Add ePayment Parameter');

	}
}