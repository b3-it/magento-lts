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
    	$item = new Varien_Object($item);
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
    
}