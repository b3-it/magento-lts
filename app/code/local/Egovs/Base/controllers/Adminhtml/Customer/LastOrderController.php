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


    public function massDeleteAction()
    {
        $customersIds = $this->getRequest()->getParam('customer');
        if(!is_array($customersIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select customer(s).'));
        } else {
            try {
                $customer = Mage::getModel('customer/customer');
                foreach ($customersIds as $customerId) {
                    $customer->reset()
                        ->load($customerId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($customersIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }


}
