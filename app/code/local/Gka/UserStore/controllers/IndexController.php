<?php
/**
 *  Auswahl fü Store
 *  @category Gka
 *  @package  Gka_UserStore
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Gka_UserStore_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
 
		$this->loadLayout();     
		$this->renderLayout();
    }
    
    
    public function switchAction()
    {
    	$userstore = $this->getRequest()->getParam('new_store');
    	if($userstore)
    	{
	    	$customer = Mage::getSingleton('customer/session')->getCustomer();
	    	$allowedStores = $customer->getAllowedStores();
	    	$store =Mage::getModel('core/store')->load($userstore);
	    	
	    	if(array_search($store->getStoreId(),$allowedStores) !== false)
	    	{
	    		Mage::app()->setCurrentStore($store->getCode());
	    		Mage::app()->getCookie()->set(Mage_Core_Model_Store::COOKIE_NAME, $store->getCode(), true);
	    	}
    	}
    	
    	if(Mage::helper('gkabase')->isModuleEnabled('Gka_Barkasse')){
    		if(Mage::getModel('gka_barkasse/kassenbuch_journal')->isCustomerCanOpen($customer->getId()))
    		{
    			$this->_redirectUrl(Mage::getModel('core/url')->getUrl('gka_barkasse/kassenbuch_journal'));
    			return;
    		}
    	}
    	
    	$this->_redirectUrl(Mage::getModel('core/url')->getUrl('catalog/index'));
    	return;
    	
    }
   
}