<?php
/**
 *  Persistenzklasse für ConfigCompare Collections
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_ConfigCompare_Model_Mysql4_CoreConfigData_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	protected $_filters = array();
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('configcompare/configcompare');
    }
    
    public function setIsLoaded()
    {
    	$this->_isCollectionLoaded = true;
    }
    
    
    public function add($item){
    	$this->_totalRecords ++;
    	if(is_array($item)){
    		$item = new Varien_Object($item);
    	}
    	$item->setConfigId($this->_totalRecords);
    	$this->addItem($item);
    }
    
    public function addOther($item){
    	$this->_totalRecords ++;
    	$item = new Varien_Object($item);
    	$item->setConfigId($this->_totalRecords);
    	$item->setOtherValue($item->getValue());
    	$item->unsetData('value');
    	$this->addItem($item);
    }
    
    public function addFieldToFilter($field, $condition = null)
    {
        	$this->_filters[$field] = $condition;
    }
    
    
    public function filter()
    {
    	if(count($this->_filters) == 0) return $this;
    	foreach($this->_items as $key => $value)
    	{
    		$flag = false;
    		foreach($this->_filters as $field => $cond){
    			if(strpos($value[$field], $cond) !== false){
    				$flag = true;
    				continue;
    			}
    		}
    		if(!$flag){
    			unset($this->_items[$key]);
    		}
    	}
    	
    	return $this;
    }
    
}