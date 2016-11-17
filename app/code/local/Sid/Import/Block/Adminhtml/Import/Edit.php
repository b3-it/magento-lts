<?php
/**
 * Sid Import
 * 
 * 
 * @category   	Sid
 * @package    	Sid_Import
 * @name       	Sid_Import_Block_Adminhtml_Import_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Import_Block_Adminhtml_Import_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'sidimport';
        $this->_controller = 'adminhtml_import';
        $this->_updateButton('save', 'label', Mage::helper('sidimport')->__('Next'));

        
        $this->removeButton('delete')
        	->removeButton('reset')
        	->removeButton('back');
        
        
		
			
      
    }

    public function getHeaderText()
    {
      return "";
    }
	
	
}