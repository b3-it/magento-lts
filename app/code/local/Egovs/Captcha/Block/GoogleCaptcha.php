<?php

class Egovs_Captcha_Block_GoogleCaptcha extends Mage_Captcha_Block_Captcha_Zend
{
    protected $_template = 'egovs/captcha/googlecaptcha.phtml';

    /**
     * Returns captcha model
     *
     * @return Mage_Captcha_Model_Abstract
     */
    public function getCaptchaModel()
    {
        return Mage::helper('egovscaptcha')->getCaptcha($this->getFormId());
    }
}