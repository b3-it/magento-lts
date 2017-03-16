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
	public function send($content,$order = null, $data = array())
	{
		$output = "";
		try
		{
			
			$tmp = tmpfile();
			$a = stream_get_meta_data($tmp);
			$filename = $a['uri'];

			$wantedFileName = "Order".$order->getIncrementId().'_'.date('d-m-Y_H-i-s').$this->getFileExtention();

			fwrite($tmp, $content);
			$cfile = curl_file_create($filename,'application/xml', $wantedFileName);
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

// 			if (Mage::getStoreConfig('web/proxy/use_proxy') == true) {
// 				$host = Mage::getStoreConfig('web/proxy/proxy_name');
// 				$port = 8080;
// 				if (strlen(Mage::getStoreConfig('web/proxy/proxy_port')>0)) {
// 					$port =  Mage::getStoreConfig('web/proxy/proxy_port');
// 				}
// 				curl_setopt($cs, CURLOPT_PROXY, $host . ":" . $port);
// 				curl_setopt($cs, CURLOPT_HTTPPROXYTUNNEL, true);
// 				//$this->useProxyAndHTTPS = true;
// 				$user = Mage::getStoreConfig('web/proxy/proxy_user');
// 				if (isset($user) && (strlen($user) > 0)) {
// 					curl_setopt($cs, CURLOPT_PROXYUSERPWD, $user . ':' . Mage::getStoreConfig('web/proxy/proxy_user_pwd'));
// 				}
// 			}
			
			$output = curl_exec($ch);
			$this->setLog($output);
			
			if(curl_error($ch))
			{
				throw new Exception(curl_error($ch));
			}
			
			$http_status = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
			
			if (($http_status < 200) || ($http_status > 210))
			{
				throw new Exception("HTTP Status: " . $http_status ." ".$output);
			}
			
			$curl_errno= curl_errno($ch);
			if($curl_errno > 0)
			{
				throw new Exception('Curl Error: '.curl_strerror($curl_errno));
			}
			
			
			
			curl_close($ch);
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
