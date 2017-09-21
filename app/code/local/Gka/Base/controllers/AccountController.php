<?php
require_once(Mage::getModuleDir('controllers','Mage_Customer').DS.'AccountController.php');

class Gka_Base_AccountController extends Mage_Customer_AccountController
{
 
    /**
     * Define target URL and redirect customer after logging in
     */
    protected function _loginPostRedirect()
    {
        $session = $this->_getSession();
		
        if ($session->isLoggedIn()) {
        	$customer = $session->getCustomer();
        	
        	
        	if(Mage::helper('gkabase')->isModuleEnabled('Gka_UserStore')){
        		$store = Mage::app()->getStore();
        		if(($customer->getAllowedStores() != null) && (count($customer->getAllowedStores()) > 1))
        		{
        			$this->_redirectUrl(Mage::getModel('core/url')->getUrl('userstore/index'));
        			return;
        		}
        	}
        	
        	
        	
        	if(Mage::helper('gkabase')->isModuleEnabled('Gka_Barkasse')){
	        	if(Mage::getModel('gka_barkasse/kassenbuch_journal')->isCustomerCanOpen($customer->getId()))
	        	{
	        		$this->_redirectUrl(Mage::getModel('core/url')->getUrl('gka_barkasse/kassenbuch_journal'));
	        		return;
	        	}
        	}
        	
        }
 
       
        
        parent::_loginPostRedirect();
    }


}
