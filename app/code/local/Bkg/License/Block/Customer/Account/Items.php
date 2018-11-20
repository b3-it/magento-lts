<?php

class Bkg_License_Block_Customer_Account_Items extends Mage_Core_Block_Template
{
    protected $_licenses = null;

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
	    if($this->_licenses == null) {

            $eav = Mage::getResourceModel('eav/entity_attribute');
            $user = Mage::getSingleton('customer/session')->getCustomer();
            $userId = intval(Mage::getSingleton('customer/session')->getCustomerId());
            $orgUnitId = intval($user->getOrgunitId);
            $collection = Mage::getModel('bkg_license/copy')->getCollection();
            $store_id = Mage::app()->getStore()->getId();


            $sql = "(SELECT copy_id, GROUP_CONCAT(coalesce(pname1.value, pname0.value) SEPARATOR ', ') as product_names FROM {$collection->getTable('bkg_license/copy_product')} AS cp ";
            $sql .= "LEFT JOIN {$collection->getTable('catalog/product')}_varchar as pname0 ON pname0.entity_id = cp.product_id AND pname0.store_id = 0 AND pname0.attribute_id = 71  ";
            $sql .= "LEFT JOIN {$collection->getTable('catalog/product')}_varchar as pname1 ON pname1.entity_id = cp.product_id AND pname1.store_id = 1 AND pname1.attribute_id = 71 ) ";

            $collection->getSelect()
                ->join(array("products"=>new Zend_Db_Expr($sql)),"products.copy_id = main_table.id",array("product_names"))
                ->where('main_table.customer_id = ' . $userId)
                ->where('main_table.status <> ' . Bkg_License_Model_Copy_Status::STATUS_INACTIVE);

            $collection->setOrder('main_table.id', 'desc');
            $this->_licenses = $collection;
        }
 			//die($collection->getSelect()->__toString());

		return$this->_licenses;
	}

    public function getLicenceDocs($licenseId)
    {
        $collection = Mage::getModel('bkg_license/copy_file')->getCollection();
        $collection->getSelect()
            ->where('main_table.copy_id = ' . $licenseId)
            ->where('main_table.usage = ' . Bkg_License_Model_Copy_Doctype::TYPE_FINAL);

        foreach($collection as $item)
        {
            $url = $this->getUrl('bkg_license/index/download',array('id'=>$item->getHashFilename()));
            $item->setDownloadUrl($url);
        }

        return $collection->getItems();
    }


	public function getItemStatus($item)
	{
		switch($item->getStatus())
		{
			case Bkg_License_Model_Copy_Status::STATUS_ACTIVE : return $this->__('Active');
			case Bkg_License_Model_Copy_Status::STATUS_INACTIVE : return $this->__('Inactive');
			case Bkg_License_Model_Copy_Status::STATUS_AUTOMATIC : return $this->__('Automatic');
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



}
