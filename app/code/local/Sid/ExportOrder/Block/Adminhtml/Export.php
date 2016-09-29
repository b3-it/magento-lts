<?php
/**
 * Sid ExportOrder
 * 
 * 
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_Block_Adminhtml_Export
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Block_Adminhtml_Export extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_export';
    $this->_blockGroup = 'sid_exportorder';
    $this->_headerText = Mage::helper('exportorder')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('exportorder')->__('Add Item');
    parent::__construct();
  }
}