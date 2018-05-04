<?php

class Bkg_Shapefile_Block_Customer_List extends Mage_Core_Block_Template
{
    
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $session = $this->_getSession();
        
        /**
         * @var Bkg_Shapefile_Model_Resource_File_Collection $col
         */
        $col = Mage::getModel('bkg_shapefile/file')->getCollection();
        $col->addFieldToFilter('customer_id', array('eq' => $session->getCustomerId()));
        $this->setItems($col);
    }
    
    /**
     * @return Mage_Customer_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }
    
    
    /**
     * Enter description here...
     *
     * @return Mage_Downloadable_Block_Customer_Products_List
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        
        $pager = $this->getLayout()->createBlock('page/html_pager', 'bkg_shapefile.customer.files.pager')
        ->setCollection($this->getItems());
        $this->setChild('pager', $pager);
        return $this;
    }
    
    public function getAllowShapefile()
    {
    	$customer = $this->_getSession()->getCustomer();
    	if(!$customer) return false;
    	return boolval($customer->getAllowShapefile());
    }
    
    public function getAddUrl() {
        return Mage::getUrl('shapefile/customer/new');
    }
    public function getUpdateUrl() {
        return Mage::getUrl('shapefile/customer/update');
    }
}