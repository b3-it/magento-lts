<?php
/**
 * Source Model für Buchungstext.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Paymentbase_Model_Attributes_Source_Abstract extends Mage_Eav_Model_Entity_Attribute_Source_Table
{
	protected $_type = null;
	
	/**
	 * Liefert ein Array von Optionen
	 * 
	 * @return array
	 * 
	 * @see Mage_Eav_Model_Entity_Attribute_Source_Table::getAllOptions()
	 */
    public function getAllOptions() {

        if (!$this->_options) {
 			$this->_options = array();
 			/* @var $collection Mage_Core_Model_Mysql4_Collection_Abstract */
 			$collection = Mage::getModel('paymentbase/haushaltsparameter')->getCollection();
 			if ($this->_type) {
	    		$collection->getSelect()->where('type = ?', $this->_type);
	    		
	    		foreach ($collection->getItems() as $item) {
	    			$this->_options[$item->getValue()] = $item->getTitle();
	    		}
 			}
    		
    		if (count($this->_options) > 1 || empty($this->_options)) {
    			$this->_options = array_reverse($this->_options, true);
    			$this->_options[''] = Mage::helper('paymentbase')->__("-- Bitte wählen --");
    			$this->_options = array_reverse($this->_options, true);
    		}
        }
        return $this->_options;
    }
}
