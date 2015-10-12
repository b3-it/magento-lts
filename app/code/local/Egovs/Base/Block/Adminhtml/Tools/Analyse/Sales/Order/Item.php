<?php

class Egovs_Base_Block_Adminhtml_Tools_Analyse_Sales_Order_Item extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
    	
    	$this->_blockGroup = 'egovsbase';
        $this->_controller = 'adminhtml_tools_analyse_sales_order_item';
        $this->_headerText = Mage::helper('egovsbase')->__('Ordered Items');
        //$this->_addButtonLabel = Mage::helper('sales')->__('Create New Order');
        parent::__construct();
       	$this->_removeButton('add');
        
    }


}
