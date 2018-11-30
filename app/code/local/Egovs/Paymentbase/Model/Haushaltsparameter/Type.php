<?php
/**
 * Resource Model für Buchungslistenparameter.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Haushaltsparameter_Type extends Varien_Object
{
    const HAUSHALTSTELLE	= 1;
    const OBJEKTNUMMER	= 2;
    const OBJEKTNUMMER_MWST = 3;
    const HREF = 4;
    const HREF_MWST = 5;
    const BUCHUNGSTEXT = 6;
    const BUCHUNGSTEXT_MWST = 7;

    /**
     * Liefert ein Array mit verfügbaren Typen
     *
     * @return array<string, string>
     */
    static public function getOptionArray() {
        return array(
            self::HAUSHALTSTELLE    => Mage::helper('paymentbase')->__('Haushaltsstelle'),
            self::OBJEKTNUMMER      => Mage::helper('paymentbase')->__('Objektnummer'),
            self::OBJEKTNUMMER_MWST => Mage::helper('paymentbase')->__('Objektnummer MwSt'),
            self::HREF              => Mage::helper('paymentbase')->__('HREF'),
            self::HREF_MWST         => Mage::helper('paymentbase')->__('HREF MwSt'),
            self::BUCHUNGSTEXT      => Mage::helper('paymentbase')->__('Buchungstext'),
            self::BUCHUNGSTEXT_MWST => Mage::helper('paymentbase')->__('Buchungstext MwSt')
        );
    }

    /**
     * Liefert ein Option-Array mit verfügbaren Typen
     *
     * Array:<br/>
     * <ul>
     *  <li>'value' => Wert</li>
     *  <li>'label' => Label</li>
     * </ul>
     *
     * @return array<string, string>
     */
    static public function getOptionHashArray() {
        $res = array();
        foreach (self::getOptionArray() as $k=>$v) {
        	$res[] = array('value'=>$k,'label'=>$v);
        }

        return $res;
    }


    static public function getAttributeName($Type)
    {
    	switch ($Type)
    	{
	    	case self::HAUSHALTSTELLE : return 'haushaltsstelle';
	    	case self::OBJEKTNUMMER: return  'objektnummer';
	        case self::OBJEKTNUMMER_MWST: return 'objektnummer_mwst';
	        case self::HREF: return 'href';
	        case self::HREF_MWST  : return 'href_mwst';
	        case self::BUCHUNGSTEXT: return 'buchungstext';
	        case self::BUCHUNGSTEXT_MWST : return 'buchungstext_mwst';
    	}
    	return null;

    }
}