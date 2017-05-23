<?php
/**
 * Liefert eine Liste aller verfügbaren Versionen
 * 
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 IT Systeme GmbH https://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Paymentbase_Model_System_Config_Source_EpayblVersion
{
	
	/**
	 * Liefert ein Array der möglichen Optionen
	 *
	 * <ul>
	 * 	<li>array 1
	 *   <ul>
	 *    <li>'value' => ID1</li>
	 *    <li>'label' => Version 2.x</li>
	 *   </ul>
	 *  </li>
	 *  <li>array 2
	 *   <ul>
	 *    <li>'value' => ID2</li>
	 *    <li>'label' => Version 3.x</li>
	 *   </ul>
	 *  </li>
	 * </ul>
	 *
	 * @return array
	 */
	public function toOptionArray() {
		
		$versions = array(
			array('value'=>'', 'label'=>Mage::helper('paymentbase')->__('Select an entry...')),
		);
		$versions[] = array('value' => Egovs_Paymentbase_Helper_Data::EPAYBL_2_X_VERSION, 'label' => 'ePayBL Version 2.x');
		$versions[] = array('value' => Egovs_Paymentbase_Helper_Data::EPAYBL_3_X_VERSION, 'label' => 'ePayBL Version 3.x');
		
		return $versions;
	}
}