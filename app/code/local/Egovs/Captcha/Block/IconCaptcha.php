<?php

/**
 * Class Egovs_Captcha_Block_IconCaptcha
 *
 * @category  Egovs
 * @package   Egovs_Captcha
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_Block_IconCaptcha extends Mage_Captcha_Block_Captcha_Zend
{
    protected $_template = 'egovs/captcha/iconcaptcha.phtml';

    /**
     * Returns URL to controller action which returns new captcha image
     *
     * @return string
     */
    public function getRefreshUrl()
    {
        $formId = $this->getFormId();
        return Mage::getUrl(
            Mage::app()->getStore()->isAdmin() ? 'adminhtml/iconcaptcha/refresh' : 'egovscaptcha/iconcaptcha/index',
            array('_secure' => Mage::app()->getStore()->isCurrentlySecure(), 'form_id' => $formId)
        );
    }
}