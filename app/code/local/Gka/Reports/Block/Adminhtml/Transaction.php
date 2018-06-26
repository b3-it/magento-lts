<?php
/**
 *
 * @category   	Gka Reports
 * @package    	Gka_Reports
 * @name       	Gka_Reports_Block_Transaction
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Reports_Block_Adminhtml_Transaction extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_transaction';
    $this->_blockGroup = 'gka_reports';
    $this->_headerText = Mage::helper('gka_reports')->__('Transaction Manager');
    $this->_addButtonLabel = Mage::helper('gka_reports')->__('Add Item');
    parent::__construct();
  }
}
