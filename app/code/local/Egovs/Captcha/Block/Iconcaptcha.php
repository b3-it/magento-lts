<?php

class Egovs_Captcha_Block_IconCaptcha extends Mage_Captcha_Block_Captcha_Zend
{
    protected $_template = 'egovs/captcha/iconcaptcha.phtml';

    /**
     * Internal constructor, that is called from real constructor
     *
     */
    protected function _construct()
    {
        parent::_construct();
    }

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