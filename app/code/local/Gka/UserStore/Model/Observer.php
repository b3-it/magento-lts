<?php

class Gka_UserStore_Model_Observer
{    
    /***
     * Überprüft die Kunden-Session
     * 
     * @param Varien_Event_Observer $observer
     * @return Gka_UserStore_Model_Observer
     */
    
    public function forceLogin($observer)
    {
       
        $session = Mage::getSingleton('customer/session');

        if (!$session->isLoggedIn()) {
            $controllerAction = $observer->getEvent()->getControllerAction();
            /* @var $controllerAction Mage_Core_Controller_Front_Action */
            $requestString = $controllerAction->getRequest()->getRequestString();

            $openActions = array(
            		'/customer/account/login',
            		'/customer/account/logoutsuccess',
            		'/customer/account/forgotpassword',
            		'/customer/account/forgotpasswordpost',
            		'/customer/account/changeforgotten',
            		'/customer/account/resetpassword',
            		'/customer/account/resetpasswordpost',
            );
            $pattern = '#^(' . implode('|', $openActions) . ')#i';
            
            if (!preg_match($pattern, $requestString)) {
                $session->setBeforeAuthUrl($requestString);
                $controllerAction->getResponse()->setRedirect(Mage::getUrl('customer/account/login'));
                $controllerAction->getResponse()->sendResponse();
                return;
            }
        }else{
        	$this->_verifyStore($session);
        }
    }
    
    /***
     * Überprüfen ob der Kunde diesen Store nutzen darf
     * @param Mage_Customer_Model_Session $session
     */
    protected function _verifyStore($session)
    {
       	$store = Mage::app()->getStore();
    	if($store)
    	{
    		$customer = $session->getCustomer();
    		$allowedStores = $customer->getAllowedStores();
    		 
    		if(count($allowedStores) < 1){
    		    $session->logout();
    		    
    		    $message = '<h1>Keine erlaubten Stores gefunden!</h1>';
    		    $session->addError($messages);

    		    Mage::app()->getResponse()->setRedirect(Mage::getUrl('customer/account/login'));
    		    Mage::app()->getResponse()->sendResponse();
    		    return;

    		    //die("<h1>Keine erlaubten Stores gefunden!</h1>");
    		}
    		
    		if(array_search($store->getStoreId(),$allowedStores) === false)
    		{
    			$storeId = array_shift($allowedStores);
    			Mage::app()->setCurrentStore($storeId);
    			Mage::app()->getCookie()->set(Mage_Core_Model_Store::COOKIE_NAME,$storeId, true);
    		}
    	}
    	
    }
}