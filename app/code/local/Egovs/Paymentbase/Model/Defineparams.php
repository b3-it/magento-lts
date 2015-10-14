<?php
/**
 * Model zum Anlegen/Definieren von Haushaltsparametern.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Defineparams extends Mage_Core_Model_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Varien_Object::_construct()
	 */
    protected function _construct() {
        parent::_construct();
        $this->_init('paymentbase/defineparams');
    }
    
    /**
     * Liefert ein Array zurück
     * 
     * Array hat die Form: <br/>
     * 
     * Array {
     * <ul>
     *  <li>ID => Titel</li>
     * </ul>
     * }
     * 
     * @return array
     */
    public function toOptions() {
    	$collection = $this->getCollection();
    	$res = array();
    	foreach ($collection->getItems() as $item) {
    		$res[$item->getId()] = $item->getTitle();
    	}
    	
    	return $res;
    }
    
    /**
     * Liefert ein Option Array zurück
     *
     * Array hat die Form: <br/>
     *
     * Array {
     * <ul>
     *  <li>'label' => Titel</li>
     *  <li>'value' => ID</li>
     * </ul>
     * }
     *
     * @return array
     */
    public function toOptionArray() {
    	$collection = $this->getCollection();
    	$res = array();
    	foreach ($collection->getItems() as $item) {
    		$res[] = array('label'=>$item->getTitle(),'value'=>$item->getId());
    	}
    	
    	return $res;
    }
}