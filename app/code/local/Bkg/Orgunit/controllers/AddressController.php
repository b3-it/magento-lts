<?php
// need to require parent because of rewrite
require_once(Mage::getModuleDir('controllers','Mage_Customer').DS.'AddressController.php');

class Bkg_Orgunit_AddressController extends Mage_Customer_AddressController
{
    /**
     * {@inheritDoc}
     * @see Mage_Customer_AddressController::formPostAction()
     */
    public function formPostAction()
    {
        if (!$this->_validateFormKey()) {
            return $this->_redirect('*/*/');
        }

        $id = $this->getRequest()->getParam('id', false);
        if ($id && $this->getRequest()->isPost()) {
            /**
             * @var Mage_Customer_Model_Address $addr
             */
            $addr = Mage::getModel('customer/address')->load($id);
            $org = $addr->getData('org_address_id');
            if ($org !== null) {
                try {
                    // only save the Default Billing and Shipping there
                    $customer = $this->_getSession()->getCustomer();
                    $addr->setCustomerId($customer->getId())
                    ->setIsDefaultBilling($this->getRequest()->getParam('default_billing', false))
                    ->setIsDefaultShipping($this->getRequest()->getParam('default_shipping', false));

                    /* no validation there */

                    $addr->save();
                    $this->_getSession()->addSuccess($this->__('The address has been saved.'));
                    $this->_redirectSuccess(Mage::getUrl('*/*/index', array('_secure'=>true)));
                    return;
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
    }
    /**
     * {@inheritDoc}
     * @see Mage_Customer_AddressController::deleteAction()
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id', false);
        if($id) {
            /**
             * @var Mage_Customer_Model_Address $addr
             */
            $addr = Mage::getModel('customer/address')->load($id);
            
            if ($addr->getData('org_address_id') !== null) {
                $this->_getSession()->addError(Mage::helper('bkg_orgunit')->__("Orgunit address can't be changed."));
                $this->_redirect('*/*/');
                return $this;
            }
        } 
        return parent::deleteAction();
    }
}