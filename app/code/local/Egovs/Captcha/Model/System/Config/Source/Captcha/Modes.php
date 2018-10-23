<?php
/**
 * Class Egovs_Captcha_Model_System_Config_Source_Captcha_Modes
 *
 * @category  Egovs
 * @package   Egovs_Captcha_Model
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_Model_System_Config_Source_Captcha_Modes
{
    /**
     * Select-Options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value'=>0, 'label'=>Mage::helper('egovscaptcha')->__('No')),
            array('value'=>1, 'label'=>Mage::helper('egovscaptcha')->__('Magento default')),
            array('value'=>2, 'label'=>Mage::helper('egovscaptcha')->__('Icon Captcha')),
            array('value'=>3, 'label'=>Mage::helper('egovscaptcha')->__('Google reCaptcha v2')),
        );
    }

}