<?php
require_once 'Mage/Adminhtml/controllers/CustomerController.php';




class Egovs_Base_Adminhtml_Customer_LastOrderController extends Mage_Adminhtml_CustomerController
{


    public function gridAction()
    {
        $this->loadLayout();

        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('egovsbase/adminhtml_customer_lastOrder_grid')->toHtml()
        );

    }

    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('customer/last_order')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Last Order'), Mage::helper('adminhtml')->__('Last Order'))
            ->_title( Mage::helper('adminhtml')->__('Last Order'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
            ->renderLayout();
    }
}
