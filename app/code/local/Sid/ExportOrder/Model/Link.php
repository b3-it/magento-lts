<?php
/**
 * Sid ExportOrder_Transfer
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder_Transfer
 * @name       	Sid_ExportOrder_Transfer_Model_Email
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Link extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/link');
    }
    
    public static function create($vendorId)
    {
    	$model = Mage::getModel('exportorder/link');
    	$random = rand(1,100);
    	$ident = md5(crypt($random,time().rand(1,1000).$vendorId));
    	$model->setIdent($ident)
    	->setCreateTime(now())
    	->setVendorId($vendorId)
    	->save();
    	 
    	return $model;
    	 
    }
    public function saveOrderIds($orderIds)
    {
    	if(is_array($orderIds) && (count($orderIds) > 0))
    	{
    		$this->_getResource()->saveOrderIds($this, $orderIds);
    	}
    }
    
    public function saveOrderStatus($orderIds, $status)
    {
    	if(is_array($orderIds) && (count($orderIds) > 0))
    	{
    		$this->_getResource()->saveOrderStatus($this, $orderIds, $status);
    	}
    }
    
    public function getDirectory()
    {
    	//     	$dir = Mage::getStoreConfig('sidhaushalt/hhexport/directory',$this->_storeId);
    	//     	$dir = trim($dir,'\\');
    	//     	$dir = trim($dir,'/');
    	//     	$dir = trim($dir,'.');
    	//     	$dir = trim($dir);
    	//     	if(strlen($dir) > 0){
    	//     		$dir .= DS;
    	//     	}
    	$dir = Mage::getBaseDir('export').DS.'orders'.DS;
    
    	try
    	{
    		if(!file_exists($dir)){
    			mkdir($dir);
    		}
    
    	}catch (Exception $ex){
    		Mage::logException($ex);
    	}
    
    	return $dir;
    }
   
    
    public function getUrl()
    {
    	return Mage::getUrl('exportorder/index/index',array('ident'=>$this->getIdent()));
    }
}
