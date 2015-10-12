<?php

/**
 * 
 *  Definition der Template Typen
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Type extends Varien_Object
{
    const TYPE_INVOICE	= 1;
    const TYPE_CREDITMEMO	= 2;
    const TYPE_DELIVERYNOTE	= 3;
    const TYPE_SEPAMANDAT	= 4;

    /**
     * Options getter
     *
     * @return array
     */
    static public function getOptionArray()
    {
        return array(
            self::TYPE_INVOICE    => Mage::helper('pdftemplate')->__('Invoice'),
            self::TYPE_CREDITMEMO   => Mage::helper('pdftemplate')->__('Creditmemo'),
            self::TYPE_DELIVERYNOTE   => Mage::helper('pdftemplate')->__('Deliverynote'),
        	self::TYPE_SEPAMANDAT   => Mage::helper('pdftemplate')->__('SEPA Mandat')
        );
    }
    
  
}