<?php
/**
 * Sid ExportOrder
 * 
 * 
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_Block_Adminhtml_Export_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Block_Adminhtml_Export_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'sid_exportorder';
        $this->_controller = 'adminhtml_export';
        
        $this->_removeButton('save');
        $this->_removeButton('delete');
        $this->_removeButton('reset');
			
      
    }

    public function getHeaderText()
    {
    	$order = Mage::registry('order');
    	return Mage::helper('exportorder')->__("History to Order '%s'", $order->getIncrementId());
    }
	
	
}