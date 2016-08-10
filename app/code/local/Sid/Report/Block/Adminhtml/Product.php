<?php
/**
 * Sid Report
 * 
 * 
 * @category   	Sid
 * @package    	Sid_Report
 * @name       	Sid_Report_Block_Adminhtml_Product
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Report_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_product';
    $this->_blockGroup = 'sidreport';
    $this->_headerText = Mage::helper('sidreport')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('sidreport')->__('Add Item');
    parent::__construct();
  }
}