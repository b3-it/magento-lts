<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Egovs
 *  @package  Bkg_VirtualAccess_Model_Service_Webservice_Client
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Service_Webservice_Client extends Varien_Object
{

	/**
	 * (non-PHPdoc)
	 * @see Sid_ExportOrder_Model_Transfer::send()
	 */
	public function send($content, $storeId = 0)
	{
		$url = Mage::getStoreConfig('virtualaccess/webservice/url');
		$output = "";
		try
		{
			$curl_opt = array();
			
			$ch = curl_init();

			// Follow any Location headers
			//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$curl_opt[CURLOPT_FOLLOWLOCATION] = 1;
			//curl_setopt($ch, CURLOPT_URL, $this->getAddress());
			$curl_opt[CURLOPT_URL] = $this->getAddress();
			//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$curl_opt[CURLOPT_RETURNTRANSFER] = 1;
			//curl_setopt($ch, CURLOPT_POST, 1);
			$curl_opt[CURLOPT_POST] = 1;
			$curl_opt[CURLOPT_HEADER] = 0;

			
			
			if(!empty($this->getPort())){
				
				//curl_setopt($ch,CURLOPT_PORT,$this->getPort());
				$curl_opt[CURLOPT_PORT] = $this->getPort();
			}
			
			if(strpos($this->getAddress(),'https:') !== false)
			{
				//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				$curl_opt[CURLOPT_SSL_VERIFYPEER] = 0;
				$curl_opt[CURLOPT_SSL_VERIFYHOST] = 0;
			}

			//$curl_opt[CURLOPT_PROXY] = '10.100.80.50:8080';
			//$curl_opt[CURLOPT_HTTPPROXYTUNNEL] = true;
			
			$data = array('file' => $cfile);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$curl_opt[CURLOPT_POSTFIELDS] = $data;
 			if (Mage::getStoreConfig('framecontract/proxy_exportorder/use_proxy') == true) {
				$host = Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_name');
 				$port = 8080;
 				if (strlen(Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_port')>0)) {
 					$port =  Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_port');
 				}
 			
 				
 				$curl_opt[CURLOPT_PROXY] = $host . ":" . $port;
 				$curl_opt[CURLOPT_HTTPPROXYTUNNEL] = true;
 				
 				$user = Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_user');
 				if (isset($user) && (strlen($user) > 0)) {
 					curl_setopt($cs, CURLOPT_PROXYUSERPWD, $user . ':' . Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_user_pwd'));
 				}
 			}
			
			foreach($curl_opt as $opt=>$value)
			{
				curl_setopt($ch, $opt, $value);
				$this->setLog('Curl SetOpt: '.$opt."=". $value);
			}
			
			$output = curl_exec($ch);
			$this->setLog($output);
			
			if(curl_error($ch))
			{
				throw new Exception(curl_error($ch));
			}
			
			$http_status = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
			
			if (($http_status < 200) || ($http_status > 210))
			{
				Sid_ExportOrder_Model_History::createHistory($order->getId(), $output);
				throw new Exception("HTTP Status: " . $http_status ." ".$output);
			}
			
			$curl_errno= curl_errno($ch);
			if($curl_errno > 0)
			{
				throw new Exception('Curl Error: '.curl_strerror($curl_errno));
			}
			
			
			
			curl_close($ch);
			if(file_exists($filename)){
				unlink($filename);
			}
		}
		catch(Exception $ex)
		{
			Mage::logException($ex);
			
			return false;
		}

	

		return trim($output);
	}
}
