<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Model_Resource_Use_options_entity_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Model_Resource_Useoptions_Collection extends Bkg_Tollpolicy_Model_Resource_Abstract_Collection
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_tollpolicy/useoptions');
    }
    
    
    public function addTollPathToSelect()
    {
    	$this->getSelect()
    		->join(array('useTable'=> $this->getTable('bkg_tollpolicy/use_type_entity')),'useTable.id= main_table.use_type_id', array('usetype_code'=>'code'))
    		->join(array('useLabelTable'=> $this->getTable('bkg_tollpolicy/use_type_label')),'useLabelTable.entity_id= useTable.id AND useLabelTable.store_id =' . $this->getStoreId(), array('use_label'=>'name'))
    		->join(array('tollTable'=> $this->getTable('bkg_tollpolicy/toll_entity')),'tollTable.id= useTable.toll_id', array('toll_code'=>'code'))
    		->join(array('tollLabelTable'=> $this->getTable('bkg_tollpolicy/toll_label')),'tollLabelTable.entity_id= tollTable.id AND tollLabelTable.store_id =' . $this->getStoreId(), array('toll_label'=>'name'))
    		->columns(new Zend_Db_Expr('concat(tollTable.code,":",useTable.code,":",main_table.code) AS toll_path_code'))
    		->columns(new Zend_Db_Expr('concat(tollLabelTable.name,":",useLabelTable.name,":",label.name) AS toll_path_label'))
    	;
    	
    	//die($this->getSelect()->__toString());
    }
    
}
