<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Model_Master_Entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Master extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_license/master');
    }
    
    public function getLicence($customer,$product,$toll)
    {
    	$collection = $this->getCollection();
    	$date = date('Y-m-d');
    	$collection->getSelect()
    		->join(array('product'=>$collection->getTable('bkg_license/master_product')),'product.master_id = main_table.id',array())
    		->join(array('cgroup'=>$collection->getTable('bkg_license/master_customergroup')),'cgroup.master_id = main_table.id',array())
    		->join(array('toll'=>$collection->getTable('bkg_license/master_toll')),'toll.master_id = main_table.id',array())
    		->where('product.product_id=?',$product->getId())
    		->where('cgroup.customergroup_id=?',$customer->getCustomerGroupId())
    		->where('toll.useoption_id=?',$toll)
    		->where('active=1')
    		->where('date_from <=?',$date)
    		->where('date_to >=?',$date)
    	;
    	
    	//der erste Treffer gewinnt
    	foreach($collection as $item)
    	{
    		return $item;
    	}
    	
    	return null;
    }
}
