<?php
/**
 * Egovs Infoletter
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Infoletter
 * @name       	Egovs_Infoletter_Block_Adminhtml_Queue
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Infoletter_Block_Adminhtml_Queue extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	

	  public function __construct()
	  {
	    $this->_controller = 'adminhtml_queue';
	    $this->_blockGroup = 'infoletter';
	    $this->_headerText = Mage::helper('infoletter')->__('Item Manager');
	    $this->_addButtonLabel = Mage::helper('infoletter')->__('Add Item');
	    parent::__construct();
	  }
	  
	  
	  
	
}