<?php

/**
 * Class Egovs_Base_Model_System_Config_Source_Email_Invoice
 *
 * @category  Egovs
 * @package   Egovs_Base
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Model_System_Config_Source_Email_Invoice
{
    const SEND_MAIL_NEVER = 0;
    const SEND_MAIL_ALWAYS = 1;
    const SEND_MAIL_GREATER_ZERO = 2;

    public function toOptionArray()
    {
        return array(
            array('value'=>self::SEND_MAIL_NEVER, 'label'=> Mage::helper('egovsbase')->__('Never')),
            array('value'=>self::SEND_MAIL_ALWAYS, 'label'=> Mage::helper('egovsbase')->__('Always')),
            array('value'=>self::SEND_MAIL_GREATER_ZERO, 'label'=> Mage::helper('egovsbase')->__('Grand total greater zero')),
        );
    }
}