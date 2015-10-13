<?php

/**
 *
 *  Definition
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Occurrence extends Varien_Object
{
	const ANY_PAGE	= 0;
    const FIRST_PAGE	= 1;
    

    /**
     * Options getter
     *
     * @return array
     */
    static public function getOptionArray()
    {
        return array(
            self::FIRST_PAGE    => Mage::helper('pdftemplate')->__('First Page Only'),
            self::ANY_PAGE   => Mage::helper('pdftemplate')->__('Any Page'),
        );
    }
}