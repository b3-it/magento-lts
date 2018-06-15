<?php
/**
 * Sid ExportOrder_Transfer
 *
 *
 * @category   	Sid
 * @package		Sid_ExportOrder_Transfer
 * @name	   	Sid_ExportOrder_Transfer_Model_Post
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
 *  @method string getField()
 *  @method setField(string $value)
 */
class Sid_ExportOrder_Model_Transfer_Post extends Sid_ExportOrder_Model_Transfer
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('exportorder/transfer_post');
	}

	/**
	 * (non-PHPdoc)
	 * @see Sid_ExportOrder_Model_Transfer::send()
	 */
	public function send($content,$order = null, $data = array(), $storeId = 0)
	{
		$output = "";
		try
		{
			$curl_opt = array();
			//$tmp = tmpfile();
			//$a = stream_get_meta_data($tmp);
			$filename = tempnam (Mage::getBaseDir('tmp'), "ExportOrder".$order->getIncrementId() ); // $a['uri'];

			$wantedFileName = "Order".$order->getIncrementId().'_'.date('d-m-Y_H-i-s').$this->getFileExtention();
			file_put_contents($filename, $content);
			
			$cfile = curl_file_create($filename,'application/xml', $wantedFileName);
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
			Sid_ExportOrder_Model_History::createHistory($order->getId(), "Fehler: Die Datei wurde nicht übertragen");
			return false;
		}

		Sid_ExportOrder_Model_History::createHistory($order->getId(), 'per Post übertragen');
		Sid_ExportOrder_Model_History::createHistory($order->getId(), 'Antwort des Servers: ' . $output);

		return trim($output);
	}
}
