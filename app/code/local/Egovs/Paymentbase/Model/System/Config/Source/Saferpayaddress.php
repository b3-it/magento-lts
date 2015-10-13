<?php
/**
 * Kapselt die Anschriftsabfragen laut Saferpaydokumentation aus der Konfiguration für Zahlungen über Saferpay
 *
 * Gilt für Giropay und Kreditkarte über Saferpay
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Adminhtml_Model_System_Config_Source_Order_Status
 */
class Egovs_Paymentbase_Model_System_Config_Source_Saferpayaddress
{
	/**
	 * Liefert ein Array der möglichen Optionen
	 *
	 * <ul>
	 * 	<li>BILLING für Rechnungsanschrift</li>
	 * 	<li>CUSTOMER für Kundenanschrift</li>
	 * 	<li>DELIVERY für Lieferanschrift</li>
	 * </ul>
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		return array(
			array('value'=>0, 'label'=>Mage::helper('adminhtml')->__('')),
			array('value'=>'DELIVERY', 'label'=>Mage::helper('paymentbase')->__('DELIVERY')),
			array('value'=>'BILLING', 'label'=>Mage::helper('paymentbase')->__('BILLING')),
			array('value'=>'CUSTOMER', 'label'=>Mage::helper('paymentbase')->__('CUSTOMER')),
		);
	}
}