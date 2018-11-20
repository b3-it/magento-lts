<?php
/**
 *
 * @category Egovs
 * @package  Egovs_Captcha_Model_Observer
 * @author René Mütterlein <r.muetterlein@b3-it.de>
 * @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH
 * @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_Model_Observer extends Mage_Captcha_Model_Observer
{
    /**
     * connect to event core_block_abstract_to_html_before
     */
    public function headBeforeHtmlforCaptcha($observer)
    {
        /**
         * @var $block Mage_Core_Block_Abstract|Mage_Page_Block_Html_Head
         */
        $block = $observer->getEvent()->getBlock();
        if ($block->getNameInLayout() !== 'head') {
            // not head
            return;
        }

        /**
         * @var $layout Mage_Core_Model_Layout
         */
        $layout = $block->getLayout();
        if (!$layout->getBlock('captcha')) {
            // doesn't has captcha block
            return;
        }

        $_type = Mage::helper('egovscaptcha')->getConfigNode('type');

        /**
         * Add CSS file to HEAD entity
         *
         * @param string $name
         * @param string $params
         * @return Mage_Page_Block_Html_Head
         */
        $block->addCss('css/' . $_type . 'captcha.css');
    }

    /**
     * Check Captcha On Forgot Password Page
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Captcha_Model_Observer
     */
    public function checkForgotpassword($observer)
    {
        $formId = 'user_forgotpassword';
        $captchaModel = Mage::helper('egovscaptcha')->getCaptcha($formId);
        if ($captchaModel->isRequired()) {
            $controller = $observer->getControllerAction();
            if ($captchaModel instanceof Mage_Captcha_Model_Zend) {
                $data = $this->_getCaptchaString($controller->getRequest(), $formId);
            } else {
                $data = $captchaModel->getRequiredPostFields($controller);
            }
            if (!$captchaModel->isCorrect($data)) {
                Mage::getSingleton('customer/session')->addError(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
                $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                $controller->getResponse()->setRedirect(Mage::getUrl('*/*/forgotpassword'));
            }
        }
        return $this;
    }

    /**
     * Check Captcha On User Login Page
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Captcha_Model_Observer
     */
    public function checkUserLogin($observer)
    {
        $formId = 'user_login';
        $captchaModel = Mage::helper('egovscaptcha')->getCaptcha($formId);
        $controller = $observer->getControllerAction();
        $loginParams = $controller->getRequest()->getPost('login');
        $login = isset($loginParams['username']) ? $loginParams['username'] : null;
        if ($captchaModel->isRequired($login)) {
            if ($captchaModel instanceof Mage_Captcha_Model_Zend) {
                $data = $this->_getCaptchaString($controller->getRequest(), $formId);
            } else {
                $data = $captchaModel->getRequiredPostFields($controller);
            }
            if (!$captchaModel->isCorrect($data)) {
                Mage::getSingleton('customer/session')->addError(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
                $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                Mage::getSingleton('customer/session')->setUsername($login);
                $beforeUrl = Mage::getSingleton('customer/session')->getBeforeAuthUrl();
                $url =  $beforeUrl ? $beforeUrl : Mage::helper('customer')->getLoginUrl();
                $controller->getResponse()->setRedirect($url);
            }
        }
        $captchaModel->logAttempt($login);
        return $this;
    }

    /**
     * Check Captcha On Register User Page
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Captcha_Model_Observer
     */
    public function checkUserCreate($observer)
    {
        $formId = 'user_create';
        /** @var \Egovs_Captcha_Model_Abstract $captchaModel */
        $captchaModel = Mage::helper('egovscaptcha')->getCaptcha($formId);
        if ($captchaModel->isRequired()) {
            $valid = "valid";

            /** @var $controller \Mage_Core_Controller_Front_Action */
            $controller = $observer->getControllerAction();

            /** Log register requests */
            $postData = NULL;
            $_logLevel = (int)Mage::getStoreConfig('dev/log/log_level');
            if ($_logLevel > Zend_Log::INFO) {
                $postData = $controller->getRequest()->getPost();
                unset($postData['password'], $postData['confirmation']);
                $postData = var_export($postData, true);
                $postData = "\nDump:" . $postData;
            } else {
                $postData = $controller->getRequest()->getPost('email', NULL);
                $postData = sprintf("\nDump:email=>%s", $postData);
            }
            $_fromIp = NULL;
            if ($_logLevel > Zend_Log::WARN) {
                $_fromIp = "From IP {$controller->getRequest()->getClientIp(true)}";
            }

            $captchaHelper = Mage::helper('egovscaptcha');
            $post = array();
            $post['firstname'] = $controller->getRequest()->getPost('firstname');
            $post['lastname'] = $controller->getRequest()->getPost('lastname');

            $honeypotFieldName = $captchaHelper->getHoneypotFieldName();
            $post[$honeypotFieldName] = $controller->getRequest()->getPost($honeypotFieldName);

            if ($captchaModel instanceof Mage_Captcha_Model_Zend) {
                if (($captchaHelper->isEnabledHoneypot() && isset($post[$honeypotFieldName]) && !empty($post[$honeypotFieldName]))
                    || ($captchaHelper->isEnabledRegexFilter() && $captchaHelper->matchesRegexFilter($post))
                ) {
                    Mage::getSingleton('customer/session')->addError(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
                    $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                    Mage::getSingleton('customer/session')->setCustomerFormData($controller->getRequest()->getPost());
                    $controller->getResponse()->setRedirect(Mage::getUrl('*/*/create'));
                    $valid = "in" . $valid;
                } else {
                    parent::checkUserCreate($observer);

                    if ($controller->getFlag(Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH) === true) {
                        $valid = "in" . $valid;
                    }
                }
            } else {
                $post = array_merge($post, $captchaModel->getRequiredPostFields($controller));

                if (($captchaHelper->isEnabledHoneypot() && isset($post[$honeypotFieldName]) && !empty($post[$honeypotFieldName]))
                    || !($_correct = $captchaModel->isCorrect($post))
                ) {
                    Mage::getSingleton('customer/session')->addError(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
                    $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                    Mage::getSingleton('customer/session')->setCustomerFormData($controller->getRequest()->getPost());
                    $controller->getResponse()->setRedirect(Mage::getUrl('*/*/create'));
                    $valid = "in" . $valid;
                }
            }

            $msg = sprintf("captcha::$valid:$_fromIp with data: $postData");
            Mage::log($msg, Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
        }
        return $this;
    }

    /**
     * Check Captcha On User Login Backend Page
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Captcha_Model_Observer
     */
    public function checkUserLoginBackend($observer)
    {
        $formId = 'backend_login';
        $captchaModel = Mage::helper('egovscaptcha')->getCaptcha($formId);
        $loginParams = Mage::app()->getRequest()->getPost('login', array());
        $login = array_key_exists('username', $loginParams) ? $loginParams['username'] : null;
        if ($captchaModel->isRequired($login)) {
            if ($captchaModel instanceof Mage_Captcha_Model_Zend) {
                $data = $this->_getCaptchaString(Mage::app()->getRequest(), $formId);
            } else {
                $controller = Mage::app()->getFrontController()->getAction();
                $data = $captchaModel->getRequiredPostFields($controller);
            }
            if (!$captchaModel->isCorrect($data)) {
                $captchaModel->logAttempt($login);
                Mage::throwException(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
            }
        }
        $captchaModel->logAttempt($login);
        return $this;
    }

    /**
     * Check Captcha On User Login Backend Page
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Captcha_Model_Observer
     */
    public function checkUserForgotPasswordBackend($observer)
    {
        $formId = 'backend_forgotpassword';
        $captchaModel = Mage::helper('egovscaptcha')->getCaptcha($formId);
        $controller = $observer->getControllerAction();
        $email = (string) $observer->getControllerAction()->getRequest()->getParam('email');
        $params = $observer->getControllerAction()->getRequest()->getParams();

        if (!empty($email) && !empty($params)){
            if ($captchaModel->isRequired()) {
                if ($captchaModel instanceof Mage_Captcha_Model_Zend) {
                    $data = $this->_getCaptchaString($controller->getRequest(), $formId);
                } else {
                    $data = $captchaModel->getRequiredPostFields($controller);
                }
                if (!$captchaModel->isCorrect($data)) {
                    $this->_getBackendSession()->setEmail((string) $controller->getRequest()->getPost('email'));
                    $controller->setFlag('', Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH, true);
                    $this->_getBackendSession()->addError(Mage::helper('captcha')->__('Incorrect CAPTCHA.'));
                    $controller->getResponse()->setRedirect(Mage::getUrl('*/*/forgotpassword'));
                }
            }
        }
        return $this;
    }
}