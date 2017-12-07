<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Resource_Components_Format_entity_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Resource_Components_Format_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
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
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_format');
    }
    
    public function getLabelTable()
    {
    	return $this->getTable('virtualgeo/components_format_label');
    }
    
    protected function _initSelect()
    {
    	$select = $this->getSelect()->from(array('main_table' => $this->getMainTable()));
    	$select->join(array('label'=>$this->getLabelTable()), "label.parent_id=main_table.id AND label.store_id=".$this->getStoreId(),array('parent_id','shortname','name','description'));
    	return $this;
    }
    
}
