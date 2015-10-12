<?php
/**
 * Frontendklasse für Guthaben
 * 
 * Mit Frontend ist nicht das Frontend des Shops gemeint!
 *
 * @category    Stala
 * @package     Stala_Extcustomer
 * @author      Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Stala_Extcustomer_Model_Customer_Attribute_Frontend_Discount extends Mage_Eav_Model_Entity_Attribute_Frontend_Abstract
{
	/**
	 * Liefert die Input Renderer Klasse
	 *
	 * @return string
	 */
	public function getInputRendererClass() {
		if ($this->getAttribute()->getAttributeCode() == 'discount_quota') {
			$className = 'extcustomer/adminhtml_customer_edit_renderer_discount';
		} else {
			$className = 'extcustomer/adminhtml_customer_edit_renderer_initialdiscount';
		}
		if ($className) {
			return Mage::getConfig()->getBlockClassName($className);
		}
		return null;
	}
}