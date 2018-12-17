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

/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method int getVendorId()
 *  @method setVendorId(int $value)
 *  @method string getIdent()
 *  @method setIdent(string $value)
 *  @method string getFilename()
 *  @method setFilename(string $value)
 *  @method string getSendFilename()
 *  @method setSendFilename(string $value)
 *  @method int getDownload()
 *  @method setDownload(int $value)
 *  @method  getDownloadTime()
 *  @method setDownloadTime( $value)
 *  @method  getCreateTime()
 *  @method setCreateTime( $value)
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
    	$random = mt_rand(1,100)."";
    	$res = self::getRandomString(10);
    	$res .= time()."";
    	$res .= $vendorId."";
    	$res .= self::getRandomString(20);
    	$res .= self::getRandomString(5,"0123456789");
    	$ident = md5($res);
    	$model->setIdent($ident)
    	->setCreateTime(now())
    	->setVendorId($vendorId)
    	->save();
    	 
    	return $model;
    	 
    }
    
    
    protected static function getRandomString($len, $chars=null)
    {
    	if (is_null($chars)) {
    		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    	}
    	mt_srand(10000000*(double)microtime());
    	for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++) {
    		$str .= $chars[mt_rand(0, $lc)];
    	}
    	return $str;
    }
    
    public function saveOrderIds($orderIds)
    {
    	if(is_array($orderIds) && (count($orderIds) > 0))
    	{
    		$this->_getResource()->saveOrderIds($this, $orderIds);
    	}
    }
    
    public function saveOrderStatus($orderIds, $status, $message)
    {
    	if(is_array($orderIds) && (count($orderIds) > 0))
    	{
    		$this->_getResource()->saveOrderStatus($this, $orderIds, $status, $message);
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
                if (!mkdir($dir) && !is_dir($dir)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
                }
    		}
    
    	}catch (Exception $ex){
    		Mage::logException($ex);
    	}
    
    	return $dir;
    }
   
    
    public function getUrl()
    {
    	$vendor = Mage::getModel('framecontract/vendor')->load($this->getVendorId());
    	$store = Mage::getModel('core/store')->load($vendor->getStoreGroup(),'group_id');
    	$params = array();
    	$params['_store'] = $store->getId();
    	$params['ident'] = $this->getIdent();
    	$url = Mage::getUrl('exportorder/index/index',$params);
    	
    	$this->setLog('URL ExportOderLink: '. $url);
    	
    	return $url;
    }
    
    
    
    protected function _beforeDelete()
    {
    	$this->deleteFile();
    }
    
    public function deleteFile()
    {
    	$filename = $this->getDirectory().$this->getFilename();
    	/* @var collection Sid_ExportOrder_Model_Resource_Link_Order_Collection */
    	$collection = Mage::getModel('exportorder/link_order')->getCollection();
    	$collection->getSelect()->where('link_id = ' .intval($this->getId()));
    	$orderIds = array();
    	foreach($collection as $item){
    		$orderIds[] = $item->getOrderId();
    	}
    	if(file_exists($filename))
    	{
    		try
    		{
    			unlink($filename);
    			Sid_ExportOrder_Model_History::createHistory($orderIds, sprintf('Datei %s gelöscht',$this->getSendFilename()));
    		}catch(Exception $ex){
    			Mage::logException($ex);
    			Sid_ExportOrder_Model_History::createHistory($orderIds, $ex->getMessage());
    		}
    	
    	}else{
    		Sid_ExportOrder_Model_History::createHistory($orderIds, sprintf('Datei %s nicht gefunden',$this->getSendFilename()));
    		$this->setLog(sprintf('Datei %s zum löschen nicht gefunden',$this->getSendFilename()));
    	}
    	return $this;
    }
    
    
}
