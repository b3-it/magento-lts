<?php

/**
 * Class Egovs_Paymentbase_Block_Adminhtml_System_Config_Form_Field_Cert
 *
 * @category  Egovs
 * @package   Egovs_Paymentbase
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_System_Config_Form_Field_Cert
    extends Mage_Adminhtml_Block_System_Config_Form_Field
{
	/**
	 * Enter description here...
	 *
	 * @param Varien_Data_Form_Element_Abstract $element Element
	 * 
	 * @return string
	 */
	public function render(Varien_Data_Form_Element_Abstract $element) {
        if (function_exists('openssl_x509_parse') && file_exists(Mage::getBaseDir().$element->getEscapedValue())) {
            //date_default_timezone_set('UTC');
            $data = openssl_x509_parse(file_get_contents(Mage::getBaseDir().$element->getEscapedValue()));

            $serialNumber = $data['serialNumber'];
            $date = new Zend_Date($data['validFrom'], 'yyMMddHHmmssz');
            $date = Mage::app()->getLocale()->storeDate(null, $date, true);
            $validFrom = $date->toString();
            $date = new Zend_Date($data['validTo'], 'yyMMddHHmmssz');
            $date = Mage::app()->getLocale()->storeDate(null, $date, true);
            $validTo = $date->toString();

            $element->setComment(
                $element->getComment() . Mage::helper('paymentbase')->__(" (Serial-Number %s valid from %s to %s)", $serialNumber, $validFrom, $validTo)
            );
        }
        return parent::render($element);
	}
}