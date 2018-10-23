<?php
/**
 * Class Egovs_Captcha_Model_System_Config_Source_Iconcaptcha_Modes
 *
 * @category  Egovs
 * @package   Egovs_Captcha_Model
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_Model_System_Config_Source_Iconcaptcha_Modes
{
    /**
     * Select-Options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value'=>light, 'label'=>Mage::helper('egovscaptcha')->__('Light Theme')),
            array('value'=>dark, 'label'=>Mage::helper('egovscaptcha')->__('Dark Theme')),
        );
    }

}