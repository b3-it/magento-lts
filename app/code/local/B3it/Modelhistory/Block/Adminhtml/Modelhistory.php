<?php
class B3it_Modelhistory_Block_Adminhtml_Modelhistory extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_modelhistory';
        $this->_blockGroup = 'modelhistory';
        $this->_headerText = "Data-Log" ; //Mage::helper('modelhistory')->__('Item Manager');
        //$this->_addButtonLabel = null; //Mage::helper('modelhistory')->__('Add Item');
        parent::__construct();
        
        $this->removeButton('add');
    }
}