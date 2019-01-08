<?php
/**
 *
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Model_Resource_Period_entity_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Model_Resource_Period_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_subscription/period');
    }
    
    public function getLabelTable()
    {
    	return $this->getTable('b3it_subscription/period_label');
    }
    
    /*
    
    protected $_storeid = 0;
    
    public function setStoreId($id)
    {
    	$this->_storeid = $id;
    	return $this;
    }
    
    public function getStoreId()
    {
    	return $this->_storeid;
    }
    
    
    
    protected function _initSelect()
    {
    	$select = $this->getSelect()->from(array('main_table' => $this->getMainTable()));
    	$select->join(array('label'=>$this->getLabelTable()), "label.entity_id=main_table.id AND label.store_id=".$this->getStoreId(),array('entity_id','shortname','name','description'));
    	return $this;
    }
    
    */
}
