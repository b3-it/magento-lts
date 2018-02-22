<?php
// need to require parent because of rewrite
require_once(Mage::getModuleDir('controllers','Mage_Customer').DS.'AddressController.php');

class Bkg_Orgunit_AddressController extends Mage_Customer_AddressController
{
    /**
     * {@inheritDoc}
     * @see Mage_Customer_AddressController::formAction()
     */
    public function formAction()
    {
        if ($this->__bkg_orgunit_check()) {
            parent::formAction();
        }
    }

    /**
     * {@inheritDoc}
     * @see Mage_Customer_AddressController::formPostAction()
     */
    public function formPostAction()
    {
        if ($this->__bkg_orgunit_check()) {
            return parent::formPostAction();
        }
    }

    /**
     * {@inheritDoc}
     * @see Mage_Customer_AddressController::deleteAction()
     */
    public function deleteAction()
    {
        if ($this->__bkg_orgunit_check()) {
            return parent::deleteAction();
        }
    }
    
    private function __bkg_orgunit_check() {
        $id = $this->getRequest()->getParam('id', false);
        
        if ($id) {
            /**
             * @var Mage_Customer_Model_Address $addr
             */
            $addr = Mage::getModel('customer/address')->load($id);
            
            if ($addr->getData('org_address_id') !== null) {
                $this->_getSession()->addError(Mage::helper('bkg_orgunit')->__("Orgunit address can't be changed."));
                $this->_redirect('*/*/');
                return false;
            }
        }
        return true;
    }
}