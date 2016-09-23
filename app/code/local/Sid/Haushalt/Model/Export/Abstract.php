<?php
/**
 *  Exportklasse für Haushalt
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Haushalt_Model_Export_Abstract extends Mage_Core_Model_Abstract
{
	protected $_filePrefix = 'export';
	protected $_fileExt = '.txt';
	protected $_orderIds = array();
	protected $_storeId = 0;
	
	
    public function _construct()
    {
        parent::_construct();
      
    }
    
   	/**
   	 * OrderId's welche exportiert weden sollen übergeben
   	 * @param unknown $orderIds
   	 */
    public function setOrderIds($orderIds)
    {
    	$this->_orderIds = $orderIds;
    }
    
    /**
     * abstrakte Methode zum Prozessieren
     * @throws Exception
     */
    public function getExportData()
    {
    	throw new Exception('Not Implemented');
    }
    
    /**
     * Dateinamen mit Zeitstempel erzeugen
     * @return string
     */
    public function getFilename()
    {
    	return $this->_filePrefix.'_'.date('d-m-Y_H-i-s').$this->_fileExt;
    }
    
    /**
     * Status für alle oderIds auf exportiert setzen
     * @param unknown $orderIds
     */
    public function setExportStatus($orderIds)
    {
    	$model = Mage::getModel('sidhaushalt/order_info')->getResource();
    	$model->setExportStatus($orderIds);
    }
    
    
    /**
     * Verzeichniss aus config relativ zu var/export ermitteln
     * @return string
     */
    protected function getDirectory()
    {
    	$dir = Mage::getStoreConfig('sidhaushalt/hhexport/directory',$this->_storeId);
    	$dir = trim($dir,'\\');
    	$dir = trim($dir,'/');
    	$dir = trim($dir,'.');
    	$dir = trim($dir);
    	if(strlen($dir) > 0){
    		$dir .= DS;
    	}
    	return Mage::getBaseDir('export').DS.$dir;
    	
    }
    
    /**
     * Daten speichern Verzeichniss wird aus konfig ermittelt
     * @param unknown $data
     */
    public function saveFile($data)
    {
    	$dir = $this->getDirectory();
    	try 
    	{
	    	if(!file_exists($dir)){
	    		
	    		mkdir($dir);
	    	}
	    	
	    	file_put_contents($dir.$this->getFilename(),$data);
    	}catch (Exception $ex){
    		Mage::logException($ex);
    	}
    }
}