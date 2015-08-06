<?php
/**
 * Liefert eine Liste aller verfügbaren Adapter
 * 
 * Adapter sind spezielle Klassen die individuelle Formate und Funktionen für die entsprechenden Kassensysteme kapseln.
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Paymentbase_Model_System_Config_Source_Adapters
{
	protected $_availableAdapters = array();
	
	/**
	 * Liefert ein Array der möglichen Optionen
	 *
	 * <ul>
	 * 	<li>array 1
	 *   <ul>
	 *    <li>'value' => ID1</li>
	 *    <li>'label' => Name1 des Adapters</li>
	 *   </ul>
	 *  </li>
	 *  <li>array 2
	 *   <ul>
	 *    <li>'value' => ID2</li>
	 *    <li>'label' => Name2 des Adapters</li>
	 *   </ul>
	 *  </li>
	 * </ul>
	 *
	 * @return array
	 */
	public function toOptionArray()
	{
		if (empty($this->_availableAdapters)) {
			$this->_availableAdapters = Mage::helper('paymentbase')->getAvailableAdapters();
		}
		
		$adpaters = array(
			array('value'=>'default', 'label'=>Mage::helper('paymentbase')->__('Default')),
		);
		foreach ($this->_availableAdapters as $adpater) {
			if ($adpater->getCode() == 'default') {
				continue;
			}
			$adpaters[] = array('value' => $adpater->getCode(), 'label' => $adpater->getLabel());
		}
		return $adpaters;
	}
}