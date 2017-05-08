<?php

class Gka_UserStore_Model_Observer
{
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
        }
    }
}