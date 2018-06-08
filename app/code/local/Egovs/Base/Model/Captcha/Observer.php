<?php
class Egovs_Base_Model_Captcha_Observer extends Mage_Captcha_Model_Observer
{
    /**
     * Check Captcha On Register User Page
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Captcha_Model_Observer
     */
    public function checkUserCreate($observer)
    {
        $formId = 'user_create';
        $captchaModel = Mage::helper('captcha')->getCaptcha($formId);
        if ($captchaModel->isRequired()) {
            /** @var $controller \Mage_Core_Controller_Front_Action*/
            $controller = $observer->getControllerAction();
            $captchaString = $this->_getCaptchaString($controller->getRequest(), $formId);
            $postData = $controller->getRequest()->getPost();
            $postData = var_export($postData, true);
            $valid = "valid";
            if (!$captchaModel->isCorrect($captchaString)) {
                Mage::getSingleton('customer/session')->addError(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
                $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                Mage::getSingleton('customer/session')->setCustomerFormData($controller->getRequest()->getPost());
                $controller->getResponse()->setRedirect(Mage::getUrl('*/*/create'));
                $valid = "in".$valid;
            }

            $msg = sprintf("captcha::$valid:From IP {$controller->getRequest()->getClientIp(true)} with captcha entered:$captchaString and captcha required:{$captchaModel->getWord()}\nDump:$postData");
            Mage::log($msg, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        }
        return $this;
    }
}