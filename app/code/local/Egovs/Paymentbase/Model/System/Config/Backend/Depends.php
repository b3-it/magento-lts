<?php
/**
 * Prüft Abhängigkeiten
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 IT Systeme GmbH - http://www.b3-it.de 
 * @license    	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_System_Config_Backend_Depends extends Egovs_Paymentbase_Model_System_Config_Backend_Abstract_Data
{
	/**
	 * Abhängigkeiten vor Speichern prüfen
	 * 
	 * @return Egovs_Paymentbase_Model_System_Config_Backend_Depends
	 * 
	 * @see Mage_Core_Model_Abstract::_beforeSave()
	 */
    protected function _beforeSave() {
    	if (!$this->_isDependencyFulfilled()) {
    		$this->_dataSaveAllowed = false;
    	}
    	parent::_beforeSave();
    	
        return $this;
    }
    
    protected function _isDependencyFulfilled() {
    	$e = $this->getFieldConfig();
    	$levels = explode('/', $this->getPath());
    	$configData = $this->getFieldsetData();
    
    	switch (count($levels)) {
    		case 3 :
    			//Field entfernen
    			array_pop($levels);
    			break;
    	}
    
    	if ($e->egovsdepend) {
    		foreach ($e->egovsdepend->children() as $dependent) {
    			/* @var $dependent Mage_Core_Model_Config_Element */
    			$dependentValue          = (string) $dependent;
    			$dependentFieldName      = $dependent->getName();
    			$path					 = $dependent->getAttribute('path');
    			if (!$path) {
    				$path = implode('/', $levels);
    			}
    			$dependentField          = "$path/$dependentFieldName";
    			 
    			$_return = false;
    			if (!isset($configData[$dependentFieldName])) {
    				//Aktuelle Daten holen
    				$groups = $this->getGroups();
    				$dependentPath = explode('/', $dependentField);
    				if (isset($dependentPath[1]) && isset($groups[$dependentPath[1]]) && isset($groups[$dependentPath[1]]['fields'][$dependentFieldName])) {
    					$dependentFieldValue = $groups[$dependentPath[1]]['fields'][$dependentFieldName]['value'];
    				} else {
	    				$dependentField = Mage::getModel('core/config_data')->load($dependentField, 'path');
	    				if ($dependentField->isEmpty()) {
	    					continue;
	    				}
	    				$dependentFieldValue = $dependentField->getValue();
    				}
    				if ($dependentFieldValue != $dependentValue) {
    					return $_return;
    				}
    			} elseif ($configData[$dependentField] != $dependentValue) {
    				return $_return;
    			}
    		}
    	}
    	 
    	return true;
    }
}
