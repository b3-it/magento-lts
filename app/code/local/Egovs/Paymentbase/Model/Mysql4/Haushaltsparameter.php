<?php
/**
 * Resource Model für Haushaltsparameter.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Mysql4_Haushaltsparameter extends Mage_Core_Model_Mysql4_Abstract
{
	/**
	 * Konstruktor
	 *
	 * @return void
	 *
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 */
    protected function _construct() {
        // Note that the paymentbase_haushaltsparameter_id refers to the key field in your database table.
        $this->_init('paymentbase/haushaltsparameter', 'paymentbase_haushaltsparameter_id');
    }

    /**
     * Zugeordnete Haushaltsstellen speichern
     *
     * @param string $objectId  ID
     * @param array $hhstellen Array von Haushaltsstellen
     *
     * @return Egovs_Paymentbase_Model_Mysql4_Haushaltsparameter
     */
    public function saveHHStellen($objectId, $hhstellen = array()) {
    	$this->_getWriteAdapter()->delete('egovs_paymentbase_objektnummer_hhstelle', "objektnummer=" . $objectId );

     	$data=array();
     	if (is_array($hhstellen) && (count($hhstellen) >0 )) {
	     	foreach ($hhstellen as $hh) {
	     		$data[] = array('hhstelle'=>$hh,'objektnummer'=>$objectId);

	     	}
	     	$this->_getWriteAdapter()->insertMultiple('egovs_paymentbase_objektnummer_hhstelle', $data);
     	}
     	return $this;
    }

    public function updateProducte($attribute, $oldValue, $newValue) {
    	//$table = $this->get
    	$id = $attribute;
    	$this->_getWriteAdapter()->update('catalog_product_entity_varchar', array('value'=>$newValue),"value = $oldValue AND attribute_id = $id");
    	return $this;
    }
}