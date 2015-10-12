<?php
/**
 * Standard Adapter.
 *
 * Für jede neue individuell einsetzbare Funktion muss die Modulversion erhöht werden, um eine Zuordnung in der Dokumentation zu gewährleisten.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Adapter_Default extends Egovs_Paymentbase_Model_Adapter_Abstract
{
	public function getLabel() {
		return Mage::helper('paymentbase')->__('Default');
	}
}