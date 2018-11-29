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
        $optionArray = array();
        $options =  parent::toOptionArray();
        $checkoutType = Mage::getStoreConfig('checkout/options/checkout_type');
        if ($checkoutType !== 'multipage') {
            return $options;
        }

        foreach ($options as $option) {
            if ($option['name'] === 'guest_checkout'
                || $option['name'] === 'sendfriend_send'
            ) {
                continue;
            }

            $optionArray[] = $option;
        }

        return $optionArray;
    }
}