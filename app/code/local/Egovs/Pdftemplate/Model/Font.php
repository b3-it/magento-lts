<?php

/**
 *
 *  Definition der Schriften
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Model_Font extends Varien_Object
{
    const FONT_HELVETICA	= 0;
    const FONT_TIMES		= 1;
    const FONT_COURIER		= 2;

    /**
     * Options getter
     *
     * @return array
     */
    static public function getOptionArray()
    {
        return array(
            self::FONT_HELVETICA    => Mage::helper('pdftemplate')->__('Helvetica'),
            self::FONT_TIMES   => Mage::helper('pdftemplate')->__('Times'),
            self::FONT_COURIER   => Mage::helper('pdftemplate')->__('Courier')
        );
    }
    
    
    /**
     * Fonts getter
     *
     * @return array
     */
	static public function getFontName($id)
    {
    	switch ($id)
    	{
    		case self::FONT_HELVETICA : return 'helvetica';
    		case self::FONT_TIMES : return 'times';
    		case self::FONT_COURIER : return 'courier';
    	}
    	return 'helvetica';
    }
    
}