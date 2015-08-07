<?php
/**
 * Frontendklasse für Readonly Attribute
 * 
 * Mit Frontend ist nicht das Frontend des Shops gemeint!
 *
 * @category    Egovs
 * @package     Egovs_Paymentbase
 * @author      Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Customer_Attribute_Frontend_Mandate extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{
	/**
	 * Liefert die Input Renderer Klasse
	 *
	 * @return string
	 */
	public function getInputRendererClass() {
		$className = 'paymentbase/adminhtml_customer_edit_renderer_mandate';
				
		return Mage::getConfig()->getBlockClassName($className);
		
	}
}