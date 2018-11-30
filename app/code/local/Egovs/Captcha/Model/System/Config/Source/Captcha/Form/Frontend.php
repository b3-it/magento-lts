<?php
/**
 * Created by PhpStorm.
 * User: Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * Date: 06.11.2018
 *
 */

/**
 * Class Egovs_Captcha_Model_System_Config_Source_Captcha_Form
 *
 * @category  Egovs
 * @package   Egovs_Captcha
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_Model_System_Config_Source_Captcha_Form_Frontend extends Mage_Captcha_Model_Config_Form_Frontend
{
    public function toOptionArray() {
        $options =  parent::toOptionArray();
        $checkoutType = Mage::getStoreConfig('checkout/options/checkout_type');
        if ($checkoutType === 'multipage') {
            array_pop($options);
            array_pop($options);
        }
        return $options;
    }
}