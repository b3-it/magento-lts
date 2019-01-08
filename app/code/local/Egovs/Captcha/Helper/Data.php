<?php
/**
 * Class Egovs_Captcha_Helper_Data
 *
 * @category  Egovs
 * @package   Egovs_Captcha
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Captcha_Helper_Data extends Mage_Captcha_Helper_Data
{
    /**
     * Get Captcha
     *
     * @param string $formId
     * @return Mage_Captcha_Model_Interface
     */
    public function getCaptcha($formId)
    {
        if (!array_key_exists($formId, $this->_captcha)) {
            $type = $this->getConfigNode('type');
            switch ($type) {
                case 'zend':
                    $this->_captcha[$formId] = Mage::getModel('captcha/' . $type, array('formId' => $formId));
                    break;
                default:
                    $this->_captcha[$formId] = Mage::getModel('egovscaptcha/' . $type, array('formId' => $formId));
            }
        }
        return $this->_captcha[$formId];
    }

    public function isEnabledRegexFilter() {
        if (Mage::app()->getStore()->isAdmin()) {
            return false;
        }
        return (bool)Mage::getStoreConfigFlag('customer/captcha/enable_regex_filter');
    }

    public function getRegexFilter() {
        return (string)Mage::getStoreConfig('customer/captcha/regex_filter');
    }

    public function matchesRegexFilter($post) {
        foreach ($post as $key => $value) {
            if (preg_match_all('/'.$this->getRegexFilter().'/im', $value)) {
                return true;
            }
        }

        return false;
    }

    public function isEnabledHoneypot() {
        if (Mage::app()->getStore()->isAdmin()) {
            return false;
        }
        return (bool)Mage::getStoreConfigFlag('customer/captcha/enable_honeypot');
    }

    public function getHoneypotFieldName() {
        return Mage::helper('core')->escapeHtml(
            (string)Mage::getStoreConfig('customer/captcha/honeypot_field_name')
        );
    }
}