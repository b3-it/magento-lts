<?php
/**
 * 
 *  Abstrakte Klasse zum verwalten der Store-Labels
 *  @category Bkg
 *  @package  Bkg_Tollpolicy_Model_Resource_Abstract_Collection
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class  Bkg_Tollpolicy_Model_Resource_Abstract_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
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
    	$select->join(array('label'=>$this->getLabelTable()), "label.entity_id=main_table.id AND label.store_id=".$this->getStoreId(),array('entity_id','name'));
    	return $this;
    }
    
    protected function getLabelTable()
    {
    	$table =  $this->getMainTable();
    	$table = str_replace('entity', 'label', $table);
    	return $table;
    }
    
}
