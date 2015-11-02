<?php
/**
 * Beschreibungsdatei für Produktinformationen
 *
 * @category	Egovs
 * @package		Egovs_ProductFile
 * @copyright	Copyright (c) 2015 B3-it System GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_ProductFile_Model_Entity_Attribute_Frontend_Productfile extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{
    public function getValue() {
        $_file  = $this->helper('productfile')->getProductFileFullName();
        $_image = $this->helper('productfile')->getProductFileUploadDirectory() . DS . $this->getProductImage();
        $_descr = $this->helper('productfile')->getProductFileDescription();
    }
}
