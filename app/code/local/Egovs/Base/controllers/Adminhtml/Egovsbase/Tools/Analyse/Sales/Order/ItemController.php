<?php

class Egovs_Base_Adminhtml_Egovsbase_Tools_Analyse_Sales_Order_ItemController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Orders grid
     */
    public function indexAction()
    {
        $this->_title($this->__('Sales'))->_title($this->__('Order Items'));
        
        $this->loadLayout()->_setActiveMenu('sales/egovs_base_order_item');
        $this->renderLayout();
    }

    /**
     * Order grid
     */
    public function gridAction()
    {
        $this->loadLayout(false);
        $this->getResponse()->setBody(
        		$this->getLayout()->createBlock('egovsbase/adminhtml_tools_analyse_sales_order_item_grid')->toHtml()
        );
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/egovs_base_order_item');
    }
}
