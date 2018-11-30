<?php
/**
 * 
 */
class B3it_Modelhistory_Block_Adminhtml_Settings_New extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_mode = 'new';
        $this->_blockGroup = 'modelhistory';
        $this->_controller = 'adminhtml_settings';
        
        //$this->_updateButton('save', 'label', Mage::helper('bkgviewer')->__('Continue'));
        
		//$this->removeButton('delete');	
		//$this->removeButton('reset');
    }

    public function getHeaderText()
    {
        return Mage::helper('core')->__('Insert Model class');
    }
	
	
}