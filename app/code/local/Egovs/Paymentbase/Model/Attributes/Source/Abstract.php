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
	protected $_options = null;
	
	/**
	 * Liefert ein Array von Optionen
	 *
     * @param bool $withEmpty       Add empty option to array
     * @param bool $defaultValues
     *
	 * @return array
	 * 
	 * @see Mage_Eav_Model_Entity_Attribute_Source_Table::getAllOptions()
	 */
    public function getAllOptions($withEmpty = true, $defaultValues = false) {

        if (!$this->_options) {
 			$this->_options = array();
 			/* @var $collection Mage_Core_Model_Mysql4_Collection_Abstract */
 			$collection = Mage::getModel('paymentbase/haushaltsparameter')->getCollection();
 			if ($this->_type) {
	    		$collection->getSelect()
                    ->where('type = ?', $this->_type)
                    ->order('title');
	    		
	    		foreach ($collection->getItems() as $item) {
	    			$this->_options[$item->getId()] = $item->getTitle();
	    		}
 			}

            if ($withEmpty) {
                $options = array('' => Mage::helper('paymentbase')->__("-- Bitte wählen --")) + $options;
            }
        }
        return $this->_options;
    }
}
