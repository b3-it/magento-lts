<?php

class Gka_Barkasse_Block_Kassenbuch_Journal_Items extends Mage_Core_Block_Template
{
    protected function _construct() {
        parent::_construct();

        $this->getItemsCollection();
    }

    /**
     * Enter description here...
     *
     * @return Dwd_Icd_Block_Customer_Credentials_Items
     */
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
		if (!$this->hasAbos()) {
			
			$userId = intval(Mage::getSingleton('customer/session')->getCustomerId());
			$collection = Mage::getModel('gka_barkasse/kassenbuch_journal')->getCollection();
			$collection->getSelect()
				->where('customer_id = ' . $userId)
				->where('status = '.Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_CLOSED);
			
	
			;
			$collection->setOrder('id', 'desc');
			$this->setAbos($collection);
 			//die($collection->getSelect()->__toString());
		}
		return $this->getAbos();
	}



	public function getItemStatus($item)
	{
		switch($item->getStatus())
		{
			case Dwd_Abo_Model_Status::STATUS_ACTIVE : return $this->__('Active');
			case Dwd_Abo_Model_Status::STATUS_CANCELED : return $this->__('Resigned');
			case Dwd_Abo_Model_Status::STATUS_DELETE : return $this->__('Deleted');
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

	public function getCancelUrl($id)
	{
		return $this->getUrl('dwd_abo/index/cancel',array('id'=>$id));
	}

	public function getApplicationUrl($item) {
		$url = $item->getApplicationUrl();

		if (!empty($url) && strpos($url, '://') === false) {
			$url = 'http://'.$url;
		}

		return $url;
	}

}
