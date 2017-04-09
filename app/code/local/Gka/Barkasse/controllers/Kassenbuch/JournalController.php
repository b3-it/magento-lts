<?php
  /**
   *
   * @category   	Gka Barkasse
   * @package    	Gka_Barkasse
   * @name        Gka_Barkasse_Kassenbuch_JournalController
   * @author 		Holger Kögel <h.koegel@b3-it.de>
   * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
   * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
   */
class Gka_Barkasse_Kassenbuch_JournalController extends Mage_Core_Controller_Front_Action
{
    protected $_customer = null;

    public function indexAction()
    {
      $id     =  intval($this->getRequest()->getParam('id'));
      
      $customer = $this->_getCustomer();
      $model = null;
      if($customer && $customer->getId()){
      	$model  = Mage::getModel('gka_barkasse/kassenbuch_journal')->getOpenJournal();
      }

      if ($model &&  $model->getId())
      {
        Mage::register('kassenbuchjournal_data', $model);
      }else{
       // Mage::getSingleton('core/session')->addError($this->__('Internal Error'));
       // Mage::log('gka_barkasse/kassenbuch_journal not found ID:'.$id);
       // $this->_redirect('customer/account');
        //return;
      }


      $this->loadLayout();
      $this->renderLayout();
    }
    
    
 	public function gridAction()
    {
    	if(!$this->_validateFormKey()){
    		$this->_redirect('customer/account/logout');
    		return;
    	}
        $this->loadLayout(false);
        $this->getResponse()->setBody(
        		$this->getLayout()->createBlock('gka_barkasse/kassenbuch_journal_grid')->toHtml()
        );
    }
    
    public function openAction()
    {
    	$opening_balance = intval($this->getRequest()->getParam('opening_balance'));
    	$cashbox_id      = intval($this->getRequest()->getParam('cashbox_id'));
    	
    	$model = Mage::getModel('gka_barkasse/kassenbuch_journal');
    	$model->setCashboxId($cashbox_id);
    	$model->setCustomerId($this->_getCustomer()->getId());
    	$model->setOpeningBalance($opening_balance);
    	$model->save();
    	
    	Mage::getSingleton('core/session')->addSuccess($this->__('Cashbox opened!'));
    	$this->_redirect('customer/account');
    	return;
    	
    	
    }
    
    public function closeAction()
    {
    	$balance = intval($this->getRequest()->getParam('closing_balance'));
    	$id      = intval($this->getRequest()->getParam('id'));
    	 
    	$model = Mage::getModel('gka_barkasse/kassenbuch_journal')->load($id);
       	$model->setClosingBalance($balance);
       	$model->setStatus(Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_CLOSED);
    	$model->save();
    	 
    	Mage::getSingleton('core/session')->addSuccess($this->__('Cashbox closed!'));
    	$this->_redirect('customer/account');
    	return;
    	 
    	 
    }

    public function preDispatch() {
    	parent::preDispatch();

    	if (!Mage::getSingleton('customer/session')->authenticate($this)) {
    		$this->setFlag('', 'no-dispatch', true);
    	}
    }

    protected function _getCustomer()
    {
        if($this->_customer == null){
          $this->_customer = Mage::getSingleton('customer/session')->getCustomer();
        }
        return $this->_customer;
    }
}
