<?php

class Egovs_GermanTax_Adminhtml_Tools_Analyse_Sales_OrderController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Orders grid
     */
    public function indexAction()
    {
        $this->_title($this->__('Sales'))->_title($this->__('Orders'));
        
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Order grid
     */
    public function gridAction()
    {
        $this->loadLayout(false);
        //$this->renderLayout();
        $this->getResponse()->setBody(
        		$this->getLayout()->createBlock('germantax/adminhtml_tools_analyse_sales_order_grid')->toHtml()
        );
    }


}
