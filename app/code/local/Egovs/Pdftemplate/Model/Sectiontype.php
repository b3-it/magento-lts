<?php
/**
 * 
 *  Definition der Template Teil Typen
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Model_Sectiontype extends Varien_Object
{
    const TYPE_HEADER	= 1;
    const TYPE_ADDRESS	= 2;
    const TYPE_BODY		= 3;
    const TYPE_FOOTER	= 4;
    const TYPE_MARGINAL	= 5;

    /**
     * Options getter
     *
     * @return array
     */
    static public function getOptionArray()
    {
        return array(
            self::TYPE_HEADER    => Mage::helper('pdftemplate')->__('Header'),
            self::TYPE_ADDRESS   => Mage::helper('pdftemplate')->__('Address'),
            self::TYPE_BODY   => Mage::helper('pdftemplate')->__('Body'),
            self::TYPE_FOOTER   => Mage::helper('pdftemplate')->__('Footer'),
            self::TYPE_MARGINAL   => Mage::helper('pdftemplate')->__('Marginal')
        );
    }
    
    
    /**
     * 
     * @param Egovs_Pdftemplate_Model_Sectiontype $id
     * @return string
     */
	static public function getHtmlPrefix($id)
    {
    	switch ($id)
    	{
    		case self::TYPE_HEADER : return 'header';
    		case self::TYPE_ADDRESS : return 'address';
    		case self::TYPE_BODY : return 'body';
    		case self::TYPE_FOOTER : return 'footer';
    		case self::TYPE_MARGINAL : return 'marginal';
    	}
    	
    }
}