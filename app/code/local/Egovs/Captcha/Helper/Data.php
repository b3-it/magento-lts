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
                case 'Zend':
                    $this->_captcha[$formId] = Mage::getModel('captcha/' . $type, array('formId' => $formId));
                    break;
                default:
                    $this->_captcha[$formId] = Mage::getModel('egovscaptcha/' . $type, array('formId' => $formId));
            }

        }
        return $this->_captcha[$formId];
    }
}