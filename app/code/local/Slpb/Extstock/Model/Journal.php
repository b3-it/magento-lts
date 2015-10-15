<?php

class Slpb_Extstock_Model_Journal extends Mage_Core_Model_Abstract
{
	const STATUS_ORDERED = 1;
	//const STATUS_SHIPPED = 2;
	const STATUS_DELIVERED = 3;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('extstock/journal');
    }
    

    public static function getStatusOptionsArray()
    {
    	return array(Slpb_Extstock_Model_Journal::STATUS_ORDERED => Mage::helper('extstock')->__('Ordered'),
    				//Slpb_Extstock_Model_Journal::STATUS_SHIPPED => 'Shipped',
					Slpb_Extstock_Model_Journal::STATUS_DELIVERED => Mage::helper('extstock')->__('Delivered')
    	);
    }
    
   public function loadWithProductInfo($id)
    {
    	$this->_getResource()->loadWithProductInfo($this, $id);
    

        return $this;
    }
    
 	public function save()
    {
    		if ($this->getDateOrdered() && !is_null($this->getDateOrdered())) {
				$date = Mage::app()->getLocale()->date($this->getDateOrdered());
				$date = $date->toString('yyyy-MM-dd');
	    		$this->setData('date_ordered', $date);
	    	}
	    	
    		if ($this->getDateDelivered() && !is_null($this->getDateDelivered())) {
				$date = Mage::app()->getLocale()->date($this->getDateDelivered());
				$date = $date->toString('yyyy-MM-dd');
	    		$this->setData('date_delivered', $date);
	    	}
	    	

	    	
	    	return parent::save();
    }
    
}