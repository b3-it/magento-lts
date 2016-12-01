<?php
/**
 * 
 *  klasse um Dateien zur Verfügung zu stellen
 *  @category Egovs
 *  @package  B3it_XmlBind_Bmecat2005_Builder_Abstract
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Import_Model_Imageloader extends B3it_XmlBind_ProductBuilder_Imageloader_Abstract
{

	private $LosId = 0;
	    
	public function getLosId() 
	{
	  return $this->LosId;
	}
	
	public function setLosId($value) 
	{
	  $this->LosId = $value;
	}
	
	public function moveImage($filename, $targetDir)
	{
		
		if(isset($this->_FilesHandled[$filename])){
			if($this->_FilesHandled[$filename] == B3it_XmlBind_ProductBuilder_Imageloader_Abstract::STATUS_OK){
				return true;
			}	
			return false;
		}
		
		$enc = base64_encode($filename);
		$url =   rtrim(Mage::getStoreConfig('framecontract/supplierportal/url'),'/');
		$url .= "/image/{$this->LosId}/{$enc}";
		$client = new Varien_Http_Client($url);
		$client->setMethod(Varien_Http_Client::GET);
		
		try{
			$response = $client->request();
			if ($response->isSuccessful()) {
				
				$targetDir = rtrim($targetDir,'/');
				if(!file_exists($targetDir)){
					mkdir($targetDir, 0750, true);
				}
				if (!is_writable($destinationFolder)) {
		            Mage::log('Destination folder is not writable or does not exists: '.$destinationFolder);
		        }
				$data = $response->getBody();
				file_put_contents($targetDir."/".$filename, $data);
		
				$this->_FilesHandled[$filename] = B3it_XmlBind_ProductBuilder_Imageloader_Abstract::STATUS_OK;
				return true;
			}
		} catch (Exception $e) {
			Mage::logException($e);
		}
		
		$this->_FilesHandled[$filename] = B3it_XmlBind_ProductBuilder_Imageloader_Abstract::STATUS_NOT_FOUND;
		return false;
	}
}
