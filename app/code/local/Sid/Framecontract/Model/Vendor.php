<?php

class Sid_Framecontract_Model_Vendor extends Mage_Core_Model_Abstract
{
	
	protected $_eventPrefix = 'framecontract_vendor';
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('framecontract/vendor');
    }
    
    public function toSelectArray()
    {
    	$res = array();
    	foreach($this->getResourceCollection()->getItems() as $item)
    	{
    		$res[] = array('label'=>$item->getCompany(),'value'=>$item->getId());
    	}
    	return $res;
    }
    
    public function toOptionArray()
    {
    	$res = array();
    	foreach($this->getResourceCollection()->getItems() as $item)
    	{
    		$res[$item->getId()] = $item->getCompany();
    	}
    	return $res;
    }
    
   /**
    * Gibt das Model zur Formatierung, initialisiert mit den Lieferantenparametern, zurück
    * @return Sid_ExportOrder_Model_Format
    */
    public function getExportFormatModel()
    {
    	$model = Sid_ExportOrder_Model_Format::getInstance($this->getExportFormat());
    	$model->load($this->getid(),'vendor_id');
    	return $model;
    }
    
    /**
     * Gibt das Model zur Versand, initialisiert mit den Lieferantenparametern, zurück
     * @return Sid_ExportOrder_Model_Transfer
     */ 
    public function getTransferModel()
    {
    	$model = Sid_ExportOrder_Model_Transfer::getInstance($this->getTransferType());
    	$model->load($this->getid(),'vendor_id');
    	return $model;
    }
 
}