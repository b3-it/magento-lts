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
    
    
    public function pdfAction() {
    	
    	$id     =  intval($this->getRequest()->getParam('id'));
    	$customerId = $this->_getCustomer()->getId();
    	
    	$collection = Mage::getModel('gka_barkasse/kassenbuch_journal')->getCollection();
    	$collection->getSelect()
    	->where('customer_id = '.$customerId)
    	->where('id = '. $id);
    	
    	//if(count($collection->getItems()) == 0) return null;
    	
    	$model =  $collection->getFirstItem();
    	
    	if ($model->getId() || $id == 0) {
    		$pdf = Mage::getModel('gka_barkasse/kassenbuch_journal_pdf');
    		//$pdf->preparePdf();
    		$pdf->Mode = Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_PREVIEW;
    		$pdf->getPdf(array($model))->render();
    	} else {
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gka_barkasse')->__('Item does not exist'));
    		$this->_redirect('*/*/');
    	}
    }
    
    public function openAction()
    {
    	$opening_balance = floatval($this->getRequest()->getParam('opening_balance'));
    	$cashbox_id      = intval($this->getRequest()->getParam('cashbox_id'));
    	
    	
    	$collection = Mage::getResourceModel('gka_barkasse/kassenbuch_cashbox_collection');
    	$collection->getSelect()
    		->where('customer_id = ' .  $this->_getCustomer()->getId())
    		->where('id = '.$cashbox_id);
    	if(count($collection->getItems()) < 1 )
    	{
    		Mage::getSingleton('core/session')->addError($this->__('Wrong CashBox selected!'));
    		$this->_redirect('gka_barkasse/kassenbuch_journal/');
    		return;
    	}
    	
    	if($opening_balance < $this->getLastBalance())
    	{
    		Mage::getSingleton('core/session')->addError($this->__('The starting amount must not be less than the final amount of the previous day!'));
    		$this->_redirect('gka_barkasse/kassenbuch_journal/');
    		return;
    	}
    	
    	$model = Mage::getModel('gka_barkasse/kassenbuch_journal');
    	$model->setCashboxId($cashbox_id);
    	$model->setCustomerId($this->_getCustomer()->getId());
    	$model->setOpeningBalance($opening_balance);
    	$model->save();
    	
    	Mage::getSingleton('core/session')->addSuccess($this->__('Cashbox opened!'));
    	$this->_redirect('gka_barkasse/kassenbuch_journal/index');
    	return;
    	
    	
    }
    
    public function getLastKassenbuchJournal()
    {
    	$collection = Mage::getModel('gka_barkasse/kassenbuch_journal')->getCollection();
    	$collection->getSelect()
    	->where('customer_id = ' . $this->_getCustomer()->getId())
    	->where('status = '.Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_CLOSED)
    	->order('id DESC');
    	 
    	return $collection->getFirstItem();
    }
    
    public function getLastBalance()
    {
    	$last = $this->getLastKassenbuchJournal();
    	if($last){
    		return $last->getClosingBalance();
    	}
    	 
    	return 0;
    }
    
    public function closeAction()
    {
    	//$balance = intval($this->getRequest()->getParam('closing_balance'));
    	$withdrawal = floatval($this->getRequest()->getParam('withdrawal'));
    	$id         = intval($this->getRequest()->getParam('id'));
    	
    	$model = Mage::getModel('gka_barkasse/kassenbuch_journal')->loadById_Customer($id);
    	if($model == null)
    	{
    		throw new Exception('Can not load Journal');
    	}
    	$balance = $model->getOpeningBalance() + $model->getTotal() - $withdrawal;
    	
    	if($balance < 0)
    	{
    		Mage::getSingleton('core/session')->addError($this->__('Closing balance must be greather than zero!'));
    		$this->_redirect('gka_barkasse/kassenbuch_journal/');
    		return;
    	}
    	
    	
    	$model->setWithdrawal($withdrawal);
       	$model->setClosingBalance($balance);
       	$model->setStatus(Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_CLOSED);
    	$model->save();
    	 
    	Mage::getSingleton('core/session')->addSuccess($this->__('Cashbox closed!'));
    	$this->_redirect('gka_barkasse/kassenbuch_journal/index');
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
