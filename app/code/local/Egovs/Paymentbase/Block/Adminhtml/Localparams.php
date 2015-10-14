<?php
/**
 * Block-Container für Buchunslistenparametern
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Localparams extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
	public function __construct() {
		$this->_controller = 'adminhtml_localparams';
		$this->_blockGroup = 'paymentbase';
		$this->_headerText = Mage::helper('paymentbase')->__('user-defined ePayment Parameter');
		$this->_addButtonLabel = Mage::helper('paymentbase')->__('Add ePayment Parameter');
		parent::__construct();
	}
}