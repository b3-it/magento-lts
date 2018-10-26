<?php
/**
 * Class Egovs_Captcha_Model_System_Config_Source_Googlecaptcha_Size
 *
 * @category  Egovs
 * @package   Egovs_Captcha_Model
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_Model_System_Config_Source_Googlecaptcha_Size
{
    /**
     * Select-Options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value'=>'compact', 'label'=>Mage::helper('egovscaptcha')->__('Compact')),
            array('value'=>'normal' , 'label'=>Mage::helper('egovscaptcha')->__('Normal')),
        );
    }

}