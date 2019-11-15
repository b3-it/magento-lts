<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_IndexController
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
   

			
		$this->loadLayout();     
		$this->renderLayout();
    }
    
    
    public function viewAction()
    {
    	$this->loadLayout();
    	//$this->getLayout()->getBlock('head')->setTitle($this->__('My Data Access'));
		$this->renderLayout();
    }
    
    public function changeAction()
    {
    	$this->loadLayout();
    	$block = $this->getLayout()->getBlock('icd_credentials');
    	$icd_id = intval($this->getRequest()->getParam('id'));
    	
    	$account = $this->_getAccount($icd_id);
    	if(!$account){
    		Mage::getSingleton('core/session')->addError($this->__('Internal Error'));
    		$this->_redirect('customer/account');
    		return;
    	}
    	
    	if ($account != null && $account->getId()) {
    		$block->setAccount($account);
    	}
    	
    	
    	$this->renderLayout();
    }
    
    public function changePostAction()
    {
    	$this->loadLayout();
    	
    	
    	$icd_id = intval($this->getRequest()->getParam('account'));
    	$pwd = $this->getRequest()->getParam('pwd');
    	$pwd_confirm = $this->getRequest()->getParam('pwd_confirm');
    	
    	if ($pwd != $pwd_confirm){
    		Mage::getSingleton('core/session')->addError($this->__('Please make sure your passwords match.'));
    		$this->_redirect('dwd_icd/index/change',array('id'=>$icd_id));
    		return;
    	}
    	
    	
    	$account = $this->_getAccount($icd_id);
    	if(!$account){
    		Mage::getSingleton('core/session')->addError($this->__('Internal Error'));
    		$this->_redirect('customer/account');
    		return;
    	}
    	
    	
    	$account->setPassword(html_entity_decode($pwd, ENT_QUOTES, 'UTF-8'));
    	
    	if(!$account->_checkPassword()){
    		Mage::getSingleton('core/session')->addError($this->__('Password does not meet requirements'));
    		$this->_redirect('dwd_icd/index/change',array('id'=>$icd_id));
    		return;
    	}
    	
    	$account->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PENDING);
    	$account->setStatus(Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_NEWPASSWORD);
    	//nur speichern falls der Account existiert
    	if($account->getId() > 0){
    		$account->save();
    	}
    	
    	Mage::getSingleton('core/session')->addSuccess($this->__('Your Password will be changed within a few minutes!'));
    	$this->_redirect('dwd_icd/index/view', array('id'=>$icd_id));
    }
    
    protected function _getAccount($accountId)
    {
    	$customer = Mage::getSingleton('customer/session')->getCustomer();
  	
    	$collection = Mage::getModel('dwd_icd/account')->getCollection();
    	
    	$collection->getSelect()
    		//join('icd_orderitem','icd_orderitem.account_id = main_table.id AND icd_orderitem.id = '.$itemId,array())
    		->where('customer_id=?', intval($customer->getId()))
    		->where('id='.intval($accountId));
    	;
    	   	
    	
    	//die($collection->getSelect()->__toString());
    	$items = $collection->getItems();
		if (count($items) > 0) {
			return array_shift($items);
		} 	
		
		Mage::log('ICD Account could not loaded. CustomerId:' . $customer->getId() . '; Account ID: '. $accountId);
		
		return null;	
		
		
    	//return Mage::getModel('dwd_icd/account');
    }
    
    public function preDispatch() {
    	parent::preDispatch();
    
    	if (!Mage::getSingleton('customer/session')->authenticate($this)) {
    		$this->setFlag('', 'no-dispatch', true);
    	}
    }
    
    public function checkPwd($pwd)
    {
    	$res = array();
    	//$res[] = $this->__('Fehler');
    	return $res;
    }
    
}