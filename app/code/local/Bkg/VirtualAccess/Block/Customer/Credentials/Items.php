<?php

class Bkg_VirtualAccess_Block_Customer_Credentials_Items extends Mage_Core_Block_Template
{
    protected function _construct() {
        parent::_construct();
        
        $this->getItemsCollection();
    }
    

    protected function _prepareLayout()
    {
    	parent::_prepareLayout();
    
    	$pager = $this->getLayout()->createBlock('page/html_pager', 'credentials.customer.items.pager')
    						->setCollection($this->getItemsCollection());
    	$this->setChild('pager', $pager);
    	$this->getItemsCollection()->load();
    	
    	return $this;
    }
    
	public function getItemsCollection()
	{
		if (!$this->hasCredentials()) {
			$eav = Mage::getResourceModel('eav/entity_attribute');
			$userId = Mage::getSingleton('customer/session')->getCustomerId();


			$collection = Mage::getModel('virtualaccess/purchased')->getCollection();
			$collection->getSelect()
				->join(array('order'=>'sales_flat_order'),'order.entity_id=main_table.order_id',array('bestellnummer'=>'increment_id','order_date'=>'created_at','original_increment_id'=>'original_increment_id'))			
				->where('main_table.customer_id = ' . $userId)
			;
			$collection->setOrder('main_table.id', 'desc');

			$this->setCredentials($collection);
 			//die($collection->getSelect()->__toString());
		}
		return $this->getCredentials();
	}
	

	
	public function getItemStatus($item)
	{
		if(($item->getSyncStatus() == Bkg_VirtualAccess_Model_Service_Syncstatus::SYNCSTATUS_PERMANENTERROR) ||
			($item->getSyncStatus() == Bkg_VirtualAccess_Model_Service_Syncstatus::SYNCSTATUS_ERROR))
		{
			return $this->__('Error');
		}
		
        switch($item->getStatus())
        {
            case Bkg_VirtualAccess_Model_Service_AccountStatus::ACCOUNTSTATUS_ACTIVE : return $this->__('Active');
        }
		return "";
		
		
	}

	public function formatCredentials($item)
    {
        $credentials = $item->getCredentials();
        if(count($credentials) > 0)
        {
            $res = array();
            foreach($credentials as $c)
            {
                $res[] =  sprintf("uuid:%s<br/>",$c->getUuid());
            }
            return implode(' ',$res);
        }
        return "";
    }


	public function formatItemDateTime($date)
	{
		return Mage::app()->getLocale()->date($date, null, null, true);	
	}
	
	public function formatItemDate($date)
	{
		$date = Mage::app()->getLocale()->date($date, null, null,  true);
		//return $date;
		return date('d.m.Y',$date->getTimestamp());
	}
	
	public function getApplicationUrl($item) {
		$url = $item->getBaseUrl();
		
		if (!empty($url) && strpos($url, '://') === false) {
			$url = 'http://'.$url;
		}
		
		return $url;
	}
}
