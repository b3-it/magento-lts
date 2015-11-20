<?php
/**
 * Stellt eine Auswahl an Steuerklassen für den Versand zur Verfügung
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Model_Adminhtml_System_Config_Source_Shipping_Taxclass
{
	/**
	 * Fügt dem Option Array einen Eintrag für die Automatische Auswahl der Steuer in Abhängigkeit der Produktsteuer hinzu.
	 * 
	 * @return array
	 */
    public function toOptionArray() {
        //$options = Mage::getModel('tax/class_source_product')->toOptionArray();
        
    	$options = array();
        array_push($options, array('value'=>-1, 'label'=>Mage::helper('germantax')->__('Depends on Product Tax')));
        
        return $options;
    }

}
