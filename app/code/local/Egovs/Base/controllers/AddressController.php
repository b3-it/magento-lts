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
        if ($this->__reject_check('egovs_base_customer_reject_address_delete')) {
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