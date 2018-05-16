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
class Bkg_License_Model_Master extends Bkg_License_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_license/master');
    }
    
    public function getLicense($customer,$product,$toll, $online_only = true, $find_all = false)
    {
    	$collection = $this->getCollection();
    	$date = date('Y-m-d');
    	$collection->getSelect()
    		->join(array('product'=>$collection->getTable('bkg_license/master_product')),'product.master_id = main_table.id',array())
    		->join(array('cgroup'=>$collection->getTable('bkg_license/master_customergroup')),'cgroup.master_id = main_table.id',array())
    		->join(array('toll'=>$collection->getTable('bkg_license/master_toll')),'toll.master_id = main_table.id',array())
    		->where('product.product_id=?',intval($product->getId()))
    		->where('cgroup.customergroup_id=?',intval($customer->getGroupId()))
    		->where('toll.useoption_id=?',intval($toll->getUseoptionId()))
    		->where('active=1')
    		->where('date_from <=?',$date)
    		->where(new Zend_Db_Expr("((date_to IS NULL) OR (date_to >='{$date}  00:00:00'))"))
    	;
    	if($online_only){
            $collection->getSelect()->where('type=?',Bkg_License_Model_Type::TYPE_ONLINE);
        }
    	
    	//die($collection->getSelect()->__toString());
    	
        if($find_all){
        	return $collection;
        }
        
    	//der erste Treffer gewinnt
    	foreach($collection as $item)
    	{
    		return $item;
    	}
    	
    	return null;
    }
    
    
    public function createCopyLicense($customer)
    {
    	$copy = Mage::getModel('bkg_license/copy');
    	
    	$data = $this->getData();
		
		unset($data['id']);
		
		$copy->setData($data);
		$copy->setCustomer($customer);
		

		
		$members = array('Agreement','Fee','Customergroup','Product','Toll');
		foreach($members as $member)
		{
			$values = array();
			$func = 'get'.$member;
			foreach($this->$func() as $item)
			{
				$values[] = $item->createCopy();
			}
			$func = 'set'.$member;
			$copy->$func($values);
		}

        $period = $this->getPeriod();
        if($period) {
            $copy->getPeriod()->setData($period->getData());
        }

        $copy->save();
		$copy->processTemplate()->save();
		$file = $copy->createPdfFile();
		if($this->getType() == Bkg_License_Model_Type::TYPE_ONLINE)
		{
			$file->setDoctype(Bkg_License_Model_Copy_Doctype::TYPE_FINAL);
		}




    	return $copy;
    }
    
    public function getPeriod()
    {
        $period = null;

        if($this->getPeriodId()) {
            $period = Mage::getModel('b3it_subscription/period')->load($this->getPeriodId());
        }
        return $period;
    }
}
