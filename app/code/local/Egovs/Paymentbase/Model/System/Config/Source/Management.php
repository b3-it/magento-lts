<?php
/**
 * Source für Typ der SEPA Mandatsverwaltung
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
abstract class Egovs_Paymentbase_Model_System_Config_Source_Management
{
	/**
	 * Payment Model
	 * 
	 * @var Egovs_Paymentbase_Model_SepaDebit
	 */
	protected $_model = null;
	/**
	 * Payment Model-Klasse
	 * 
	 * @var string
	 */
	protected $_modelClassName;
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	$options = array();
    	if ($this->__canInternalMandateManagement()) {
    		$options[] = array('value' => 0, 'label'=>Mage::helper('paymentbase')->__('Internal'));
    	}
    	if ($this->__canExternalMandateManagement()) {
    		$options[] = array('value' => 1, 'label'=>Mage::helper('paymentbase')->__('External'));
    	}
    	
    	return $options;
    }
    
    /**
     * Liefert die Objekt-Instanz
     * 
     * Die Model-Klasse muss über $_modelClassName festgelegt werden!
     * 
     * @return Egovs_Paymentbase_Model_SepaDebit
     */
    protected function _getModel() {
    	if (is_null($this->_model)) {
    		$this->_model = Mage::getModel($this->_modelClassName);
    	}
    	
    	return $this->_model;
    }
    
    private function __canExternalMandateManagement() {
    	return $this->_getModel()->canExternalMandateManagement();
    }
    private function __canInternalMandateManagement() {
    	return $this->_getModel()->canInternalMandateManagement();
    }
}
