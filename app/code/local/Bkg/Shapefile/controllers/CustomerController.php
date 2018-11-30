<?php

class Bkg_Shapefile_CustomerController extends Mage_Core_Controller_Front_Action
{
    public function listAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
    
    
    public function getAllowShapefile()
    {
    	$customer = $this->_getSession()->getCustomer();
    	if(!$customer) return false;
    	return boolval($customer->getAllowShapefile());
    }
    
    public function newAction() {
    	if($this->getAllowShapefile())
    	{
	        if (!empty($_FILES)) {
	            if (array_key_exists('shp', $_FILES)) {
	                $shp = $_FILES['shp']['tmp_name'];
	            }
	            if (array_key_exists('dbf', $_FILES)) {
	                $dbf = $_FILES['dbf']['tmp_name'];
	            }
	            if (array_key_exists('shp', $_FILES)) {
	                $shx = $_FILES['shx']['tmp_name'];
	            }
	            
	            if (empty($shp) || empty($dbf) || empty($shx)) {
	                $this->_getSession()->addError(Mage::helper('bkg_shapefile')->__('One of the Files missing'));
	                return $this->_redirect('*/*/list');
	            }
	            /**
	             * @var Bkg_Shapefile_Helper_Data $helper
	             */
	            $helper = Mage::helper('bkg_shapefile');
	            try {
	                $helper->newShapeFile($shp, $dbf, $shx, $this->getRequest()->getParam('name'), $this->getRequest()->getParam('georef'), $this->_getSession()->getCustomerId());
	            } catch (\ShapeFile\ShapeFileException $e) {
	                $this->_getSession()->addException($e, Mage::helper('bkg_shapefile')->__('Error with shape file upload'));
	            } catch (\Exception $e) {
	                $this->_getSession()->addException($e, $e->getMessage());
	            }
	            return $this->_redirect('*/*/list');
	            
	        }
    	}
    }
    
    public function updateAction() {
    	if($this->getAllowShapefile())
    	{
	        $del = $this->getRequest()->getParam("_delete");
	        if (!isset($del)) {
	            return $this->_redirect('*/*/list');
	        }
	        // TODO add way to update names
	        
	        /**
	         * @var Bkg_Shapefile_Model_Resource_File_Collection $col
	         */
	        $col = Mage::getModel("bkg_shapefile/file")->getCollection();
	        $col->addFieldToFilter('customer_id', array('eq' => $this->_getSession()->getCustomerId()));
	        $col->addFieldToFilter('id', array('in' => $del));
	
	        foreach ($col->getItems() as $item) {
	            /**
	             * @var Bkg_Shapefile_Model_File $item
	             */
	            $item->delete();
	        }
    	}
        return $this->_redirect('*/*/list');
    }

    /**
     * @return Mage_Customer_Model_Session
     */
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }
    
    /**
     * Check customer authentication
     */
    public function preDispatch()
    {
        parent::preDispatch();
        
        $loginUrl = Mage::helper('customer')->getLoginUrl();
        
        if (!$this->_getSession()->authenticate($this, $loginUrl)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
        }
    }
}