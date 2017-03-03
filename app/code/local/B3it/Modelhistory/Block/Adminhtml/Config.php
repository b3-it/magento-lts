<?php
class B3it_Modelhistory_Block_Adminhtml_Config extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_config';
        $this->_blockGroup = 'modelhistory';
        $this->_headerText = "Config-Log" ; //Mage::helper('modelhistory')->__('Item Manager');
        //$this->_addButtonLabel = null; //Mage::helper('modelhistory')->__('Add Item');
        parent::__construct();
        
        $this->removeButton('add');
    }
}