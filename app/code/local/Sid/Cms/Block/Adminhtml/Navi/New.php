<?php
/**
 * Sid Cms
 * 
 * 
 * @category   	Sid
 * @package    	Sid_Cms
 * @name       	Sid_Cms_Block_Adminhtml_Navi_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Block_Adminhtml_Navi_New extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'sidcms';
        $this->_controller = 'adminhtml_navi';
        $this->_mode = 'new';
        
        $this->_updateButton('save', 'label', Mage::helper('sidcms')->__('Continue'));
        
		$this->removeButton('delete');	
		$this->removeButton('reset');
    }

    public function getHeaderText()
    {
        return Mage::helper('sidcms')->__('Select Store');
    }
	
	
}