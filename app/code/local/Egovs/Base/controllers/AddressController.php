<?php
// need to require parent because of rewrite
require_once(Mage::getModuleDir('controllers','Mage_Customer').DS.'AddressController.php');

class Egovs_Base_AddressController extends Mage_Customer_AddressController
{
    /**
     * {@inheritDoc}
     * @see Mage_Customer_AddressController::formAction()
     */
    public function formAction()
    {
        if (!$this->__reject_check('egovs_base_customer_reject_address_edit'))  {
            parent::formAction();
        }else{
            $this->_getSession()->addError($this->__('This address can not be changed.'));
            $this->getResponse()->setRedirect(Mage::getUrl('*/*/index'));
        }
    }

    /**
     * {@inheritDoc}
     * @see Mage_Customer_AddressController::formPostAction()
     */
    public function formPostAction()
    {
        if (!$this->__reject_check('egovs_base_customer_reject_address_save')) {
            $id = $this->getRequest()->getParam('id', false);
            if ($id && $this->getRequest()->isPost()) {
                /**
                 * @var Mage_Customer_Model_Address $addr
                 * @var Egovs_Base_Helper_Customer_Address $helper
                 */
                $addr = Mage::getModel('customer/address')->load($id);
                $helper = Mage::helper('egovsbase/customer_address');

                // read only address does skip validator and other stuff and only does care about 
                // default shipping and billing flags
                if ($helper->isAddressReadOnly($addr)) {
                    try {
                        // only save the Default Billing and Shipping there
                        $customer = $this->_getSession()->getCustomer();
                        $addr->setCustomerId($customer->getId())
                        ->setIsDefaultBilling($this->getRequest()->getParam('default_billing', false))
                        ->setIsDefaultShipping($this->getRequest()->getParam('default_shipping', false));
                        
                        /* no validation there */
                        
                        $addr->save();
                        $this->_getSession()->addSuccess($this->__('The address has been saved.'));
                        return $this->_redirectSuccess(Mage::getUrl('*/*/index', array('_secure'=>true)));
                    } catch (Mage_Core_Exception $e) {
                        $this->_getSession()->setAddressFormData($this->getRequest()->getPost())
                        ->addException($e, $e->getMessage());
                    } catch (Exception $e) {
                        $this->_getSession()->setAddressFormData($this->getRequest()->getPost())
                        ->addException($e, $this->__('Cannot save address.'));
                    }
                    return $this->_redirectError(Mage::getUrl('*/*/edit', array('id' => $addr->getId())));
                }
            }
            return parent::formPostAction();
        }else{
            $this->_getSession()->addError($this->__('This address can not be changed.'));
            $this->getResponse()->setRedirect(Mage::getUrl('*/*/index'));
        }
    }

    /**
     * {@inheritDoc}
     * @see Mage_Customer_AddressController::deleteAction()
     */
    public function deleteAction()
    {
        if (!$this->__reject_check('egovs_base_customer_reject_address_delete')) {
            return parent::deleteAction();
        }else{
            $this->_getSession()->addError($this->__('This address can not be changed.'));
            $this->getResponse()->setRedirect(Mage::getUrl('*/*/index'));
        }
    }




    private function __reject_check($event) {
        $id = $this->getRequest()->getParam('id', false);
        $result = new Varien_Object();
        $data = array('result' => $result, "address_id" => $id);
        Mage::dispatchEvent($event, $data);

        $_res = boolval($result->getIsDenied());
        return $_res;
    }
}