<?php

/**
 * 
 *  Verwaltung des Lieferanten
 *  @category Egovs
 *  @package  Sid_Framecontract_Model_Vendor
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


/**
 *  @method int getFramecontractVendorId()
 *  @method setFramecontractVendorId(int $value)
 *  @method string getCompany()
 *  @method setCompany(string $value)
 *  @method string getOperator()
 *  @method setOperator(string $value)
 *  @method string getOrderEmail()
 *  @method setOrderEmail(string $value)
 *  @method string getEmail()
 *  @method setEmail(string $value)
 *  @method string getStreet()
 *  @method setStreet(string $value)
 *  @method string getCity()
 *  @method setCity(string $value)
 *  @method string getPlz()
 *  @method setPlz(string $value)
 *  @method string getFax()
 *  @method setFax(string $value)
 *  @method string getTel()
 *  @method setTel(string $value)
 *  @method string getCountry()
 *  @method setCountry(string $value)
 *  @method  getCreatedTime()
 *  @method setCreatedTime( $value)
 *  @method  getUpdateTime()
 *  @method setUpdateTime( $value)
 *  @method string getExportFormat()
 *  @method setExportFormat(string $value)
 *  @method string getTransferType()
 *  @method setTransferType(string $value)
 *  @method string getClaimEmail()
 *  @method setClaimEmail(string $value)
 */

class Sid_Framecontract_Model_Vendor extends Mage_Core_Model_Abstract
{

	/**
	 * Prefix of model events names
	 *
	 * @var string
	 */
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