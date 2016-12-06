<?php
/**
 * Sid ExportOrder_Transfer
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder_Transfer
 * @name       	Sid_ExportOrder_Transfer_Model_Post
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method int getVendorId()
 *  @method setVendorId(int $value)
 *  @method string getAddress()
 *  @method setAddress(string $value)
 *  @method string getPort()
 *  @method setPort(string $value)
 *  @method string getUser()
 *  @method setUser(string $value)
 *  @method string getPwd()
 *  @method setPwd(string $value)
 */
class Sid_ExportOrder_Model_Transfer_Post extends Sid_ExportOrder_Model_Transfer
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/transfer_post');
    }
    
    public function send($content,$order = null)
    {
    	$output = "";
    	try 
    	{
    	    	
	    	$filename =$order->getIncrementId().'_'.date('d-m-Y_H-i-s').$this->getFileExtention();
	    	$path =  Mage::getBaseDir('tmp').DS. $filename;
	    	
	    	file_put_contents($path, $content);
	    	$this->setLog('Erzeuge tmp Datei: '.$path);
	    	$cfile = new CURLFile($filename,'application/xml','Filedata');
	    	$ch = curl_init();
	    	
	    	// Follow any Location headers
	    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    	
	    	curl_setopt($ch, CURLOPT_URL, $this->getAddress());
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    	curl_setopt($ch, CURLOPT_POST, 1);
	    	
	    	if(!empty($this->getUser())){
	    		$this->setLog('setze Username: '. $this->getUser());
	    		curl_setopt($ch,CURLOPT_PROXYUSERPWD,$this->getUser().':'.$this->getPwd());
	    	}
	    	
	    	$data = array('file' => $cfile);
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    	
	    	$output = curl_exec($ch);
	    	curl_close($ch);
	    	if(file_exists($path))
	    	{
	    		unlink($path);
	    		$this->setLog('Lösche tmp Datei: '.$path);
	    	}
    	}
    	catch(Exception $ex)
    	{
    		$output = $ex->getMessage();
    		Mage::logException($ex);
    	}
    	
    	Sid_ExportOrder_Model_History::createHistory($order->getId(), 'per Post übertragen');
    	
    	return trim($output);
    }
}
