<?php
/**
 * Created by PhpStorm.
 * User: Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * Date: 23.10.2018
 *
 */

/**
 * Class Egovs_Captcha_Model_Abstract
 *
 * @category  Egovs
 * @package   Egovs_Captcha
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Captcha_Model_Abstract extends Mage_Core_Model_Abstract
{
    protected $_helper;
    protected $_formId;
    protected $_expiration;


    /**
     * Zend captcha constructor
     *
     * @param array $params
     */
    public function __construct($params)
    {
        if (!isset($params['formId'])) {
            throw new Exception('formId is mandatory');
        }
        $this->_formId = $params['formId'];
    }

    /**
     * Returns key with respect of current form ID
     *
     * @param string $key
     * @return string
     */
    protected function _getFormIdKey($key)
    {
        return $this->_formId . '_' . $key;
    }

    /**
     * Returns captcha helper
     *
     * @return Mage_Captcha_Helper_Data
     */
    protected function _getHelper()
    {
        if (empty($this->_helper)) {
            $this->_helper = Mage::helper('egovscaptcha');
        }
        return $this->_helper;
    }

    /**
     * Check is user auth
     *
     * @return bool
     */
    protected function _isUserAuth()
    {
        return Mage::app()->getStore()->isAdmin()
            ? Mage::getSingleton('admin/session')->isLoggedIn()
            : Mage::getSingleton('customer/session')->isLoggedIn();
    }

    /**
     * Whether captcha is enabled at this area
     *
     * @return bool
     */
    protected function _isEnabled()
    {
        return (string)$this->_getHelper()->getConfigNode('enable');
    }

    /**
     * Retrieve list of forms where captcha must be shown
     *
     * For frontend this list is based on current website
     *
     * @return array
     */
    protected function _getTargetForms()
    {
        $formsString = (string) $this->_getHelper()->getConfigNode('forms');
        return explode(',', $formsString);
    }

    /**
     * Returns number of allowed attempts for same login
     *
     * @return int
     */
    protected function _getAllowedAttemptsForSameLogin()
    {
        return (int)$this->_getHelper()->getConfigNode('failed_attempts_login');
    }

    /**
     * Returns number of allowed attempts from same IP
     *
     * @return int
     */
    protected function _getAllowedAttemptsFromSameIp()
    {
        return (int)$this->_getHelper()->getConfigNode('failed_attempts_ip');
    }

    /**
     * Whether to show captcha for this form every time
     *
     * @return bool
     */
    protected function _isShowAlways()
    {
        // setting the allowed attempts to 0 is like setting mode to always
        if ($this->_getAllowedAttemptsForSameLogin() == 0 || $this->_getAllowedAttemptsFromSameIp() == 0) {
            return true;
        }

        if ((string)$this->_getHelper()->getConfigNode('mode') == Mage_Captcha_Helper_Data::MODE_ALWAYS) {
            return true;
        }

        $alwaysFor = $this->_getHelper()->getConfigNode('always_for');
        foreach ($alwaysFor as $nodeFormId => $isAlwaysFor) {
            if ($isAlwaysFor && $this->_formId == $nodeFormId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check is overlimit saved attempts from one ip
     *
     * @return bool
     */
    protected function _isOverLimitIpAttempt()
    {
        $countAttemptsByIp = Mage::getResourceModel('captcha/log')->countAttemptsByRemoteAddress();
        return $countAttemptsByIp >= $this->_getAllowedAttemptsFromSameIp();
    }

    /**
     * Check is overlimit attempts
     *
     * @param string $login
     * @return bool
     */
    protected function _isOverLimitAttempts($login)
    {
        return ($this->_isOverLimitIpAttempt() || $this->_isOverLimitLoginAttempts($login));
    }

    /**
     * Is Over Limit Login Attempts
     *
     * @param string $login
     * @return bool
     */
    protected function _isOverLimitLoginAttempts($login)
    {
        if ($login != false) {
            $countAttemptsByLogin = Mage::getResourceModel('captcha/log')->countAttemptsByUserLogin($login);
            return ($countAttemptsByLogin >= $this->_getAllowedAttemptsForSameLogin());
        }
        return false;
    }

    /**
     * Whether captcha is required to be inserted to this form
     *
     * @param null|string $login
     * @return bool
     */
    public function isRequired($login = null)
    {
        $nonAuthForms = array('wishlist_sharing', 'sendfriend_send');

        if ((!in_array($this->_formId, $nonAuthForms) && $this->_isUserAuth())
            || !$this->_isEnabled() || !in_array($this->_formId, $this->_getTargetForms(), true)) {
            return false;
        }

        return ($this->_isShowAlways() || $this->_isOverLimitAttempts($login)
            || $this->getSession()->getData($this->_getFormIdKey('show_captcha'))
        );
    }

    /**
     * After this time isCorrect() is going to return FALSE even if word was guessed correctly
     *
     * @return int
     */
    public function getTimeout()
    {
        if (!$this->_expiration) {
            /**
             * as "timeout" configuration parameter specifies timeout in minutes - we multiply it on 60 to set
             * expiration in seconds
             */
            $this->_expiration = (int)$this->_getHelper()->getConfigNode('timeout') * 60;
        }
        return $this->_expiration;
    }

    /**
     * Returns session instance
     *
     * @return Mage_Customer_Model_Session
     */
    public function getSession()
    {
        return Mage::getSingleton('customer/session');
    }

    /**
     * Checks whether solution entered by user corresponds to the one generated
     *
     * @param array $post
     *
     * @return bool
     */
    final public function isCorrect($post) {
        $sessionData = $this->getSession()->getData($this->_getFormIdKey('captcha'));
        if (time() >= $sessionData['expires']) {
            return false;
        }
        if ($this->isEnabledRegexFilter() && $this->matchesRegexFilter($post)) {
            return false;
        }

        $this->getSession()->unsetData($this->_getFormIdKey('captcha'));
        return $this->_isCorrect($post);
    }

    abstract protected function _isCorrect(array $post);

    public function isEnabledRegexFilter() {
        return Mage::helper('egovscaptcha')->isEnabledRegexFilter();
    }

    public function getRegexFilter() {
        return Mage::helper('egovscaptcha')->getRegexFilter();
    }

    public function isEnabledHoneypot() {
        return Mage::helper('egovscaptcha')->isEnabledHoneypot();
    }

    public function getHoneypotFieldName() {
        return Mage::helper('egovscaptcha')->getHoneypotFieldName();
    }

    public function matchesRegexFilter($post) {
        return Mage::helper('egovscaptcha')->matchesRegexFilter($post);
    }

    abstract public function getRequiredPostFields($controller);

    /**
     * log Attempt
     *
     * @param string $login
     * @return Mage_Captcha_Model_Zend
     */
    public function logAttempt($login)
    {
        if ($this->_isEnabled() && in_array($this->_formId, $this->_getTargetForms())) {
            Mage::getResourceModel('captcha/log')->logAttempt($login);
            if ($this->_isOverLimitLoginAttempts($login)) {
                $this->getSession()->setData($this->_getFormIdKey('show_captcha'), 1);
            }
        }
        return $this;
    }
}
