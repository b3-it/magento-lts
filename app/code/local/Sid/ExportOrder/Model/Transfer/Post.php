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
 *  @method string getClientCertificate()
 *  @method string getClientCertificatePwd()
 *  @method string getClientCa()
 *  @method bool getClientcertAuth()
 *
 */
class Sid_ExportOrder_Model_Transfer_Post extends Sid_ExportOrder_Model_Transfer
{
    private $_filenameWithPath = null;

	public function _construct()
	{
		parent::_construct();
		$this->_init('exportorder/transfer_post');
	}

	/**
	 * (non-PHPdoc)
	 * @see Sid_ExportOrder_Model_Transfer::send()
	 */
	protected function _sendCurl($content,$order = null, $data = array(), $storeId = 0)
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
 				if (strlen(Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_port')) > 0) {
 					$port =  Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_port');
 				}
 			
 				
 				$curl_opt[CURLOPT_PROXY] = $host . ":" . $port;
 				$curl_opt[CURLOPT_HTTPPROXYTUNNEL] = true;
 				
 				$user = Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_user');
 				if (isset($user) && (strlen($user) > 0)) {
 					curl_setopt($ch, CURLOPT_PROXYUSERPWD, $user . ':' . Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_user_pwd'));
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

    /**
     * Sendet Daten per POST
     *
     * @param       $content
     * @param null  $order
     * @param array $data
     *
     * @return string Bei Erfolg Body des Response
     * @throws \Exception Im Fehlerfall
     */
	protected function _sendHttpful($content, $order = null, $data = array()) {
	    require_once 'Httpful/Bootstrap.php';
	    \Httpful\Bootstrap::init();

	    $uri = $this->getAddress();
	    $parsedUri = parse_url($uri);
	    if (!isset($parsedUri['scheme'])) {
	        $uri = 'http://'.ltrim($uri, ':/');
        }

	    $request = \Httpful\Request::post($uri)
            ->followRedirects(true)
        ;

        if(!empty($this->getPort())) {
            $request->addOnCurlOption(CURLOPT_PORT, $this->getPort());
        }

        if (Mage::getStoreConfigFlag('framecontract/proxy_exportorder/use_proxy') == true) {
            $host = Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_name');
            $port = 8080;
            if (strlen(Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_port')) > 0) {
                $port =  Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_port');
            }

            $user = Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_user');
            $pwd = Mage::getStoreConfig('framecontract/proxy_exportorder/proxy_user_pwd');
            $request->useProxy(
                $host,
                $port,
                empty($user) ? null : CURLAUTH_BASIC,
                empty($user) ? null : $user,
                empty($user) || empty($pwd) ? null : $pwd
            );
            $request->addOnCurlOption(CURLOPT_HTTPPROXYTUNNEL, true);
        }

        if($order) {
            $filename = "Order" . $order->getIncrementId() . '_' . date('d-m-Y_H-i-s') . $this->getFileExtention();
            $filenameWithPath = Mage::getBaseDir('tmp') .DS . $filename;
            $this->_filenameWithPath = $filenameWithPath;

            try {
                file_put_contents($filenameWithPath, $content);
                $request->attach(array('file' => $filenameWithPath));
            } catch(Exception $ex) {
                Mage::logException($ex);
                Sid_ExportOrder_Model_History::createHistory($order->getId(), "Fehler: Die Datei wurde nicht übertragen");
                throw new Exception('Dateianhang konnte nicht erstellt werden!');
            }
        } else {
            $request->body('CHECK CONNECTION');
        }

        if ($this->getClientcertAuth()) {
            if ($this->getClientCertificate()) {
                $key = $cert = Mage::helper('exportorder')->getBaseStorePathForCertificates() . $this->getClientCertificate();
                $request
                    ->authenticateWithCert($cert, $key, $this->getClientCertificatePwd())
                    ->withStrictSSL();
            }
            if ($this->getClientCa()) {
                $request
                    ->addOnCurlOption(CURLOPT_CAINFO, Mage::helper('exportorder')->getBaseStorePathForCertificates() . $this->getClientCa())
                    ->addOnCurlOption(CURLOPT_CAPATH, Mage::helper('exportorder')->getBaseStorePathForCertificates() . $this->getClientCa())
                    ->withStrictSSL();
            }
        } elseif (isset($parsedUri['scheme']) && strtolower($parsedUri['scheme']) == 'https') {
            $request->withoutStrictSSL();
        }

        try {
            $response = $request->send();
        } catch (Exception $e) {
            Mage::logException($e);
            if ($order) {
                Sid_ExportOrder_Model_History::createHistory($order->getId(), $e->getMessage());
            }
            throw $e;
        }

        $httpStatus = $response->code;
        $output = $response->raw_body;

        if ($order) {
            if (($httpStatus < 200) || ($httpStatus > 210)) {
                Sid_ExportOrder_Model_History::createHistory($order->getId(), $output);
                throw new Exception("HTTP Status/Output: " . $httpStatus . " / " . $output);
            }
        } elseif (!$httpStatus || empty($output)) {
            throw new Exception("HTTP Status/Output: " . $httpStatus . " / " . $output);
        }

        if ($order) {
            Sid_ExportOrder_Model_History::createHistory($order->getId(), 'per Post übertragen');
            Sid_ExportOrder_Model_History::createHistory($order->getId(), 'Antwort des Servers: ' . $output);
        }

        return $output;
    }

    protected function _removeFile($filenameWithPath = null) {
	    if (is_null($filenameWithPath)) {
	        $filenameWithPath = $this->_filenameWithPath;
        }

        if(!is_null($filenameWithPath) && file_exists($filenameWithPath)){
            @unlink($filenameWithPath);
        }

        return $this;
    }

    public function send($content, $order = null, $data = array()) {
        $this->_filenameWithPath = null;
        $_result = false;
        try {
            $_result = $this->_sendHttpful($content, $order, $data);
            //$_result = $this->_sendCurl($content, $order, $data);
        } catch (Exception $e) {
            $this->_removeFile();
            throw $e;
        }
        if ($_result === true) {
            $_result = "Die Bestellung wurde erfolgreich versendet.";
        }
        $this->_removeFile();
        return $_result;
    }

    /**
     * Check connection
     *
     * @return bool|string
     */
    public function checkConnection() {
        $this->_filenameWithPath = null;
        $_result = false;
        try {
            $_result = $this->_sendHttpful(null);
        } catch (\Httpful\Exception\ConnectionErrorException $cee) {
            Mage::logException($cee);
            if ($cee->getCurlErrorNumber() == 35) {
                $_result = Mage::helper('exportorder')->__("Wrong client certificate specified!");
                $_result .= " " . $cee->getMessage();
            } else {
                $_result = $cee->getMessage();
            }
        } catch (Exception $e) {
            Mage::logException($e);
            $_result = $e->getMessage();
        }
        if (is_string($_result) && !isset($e) && !isset($cee)) {
            $_result = true;
        }
        return $_result;
    }

    protected function _afterLoad() {
        if ($this->getClientCertificatePwd()) {
            $this->setData('client_certificate_pwd', Mage::helper('core')->decrypt($this->getClientCertificatePwd()));
        }
        return parent::_afterLoad(); // TODO: Change the autogenerated stub
    }

    protected function _beforeSave() {
        if ($this->getClientCertificatePwd()) {
            $this->setData('client_certificate_pwd', Mage::helper('core')->encrypt($this->getClientCertificatePwd()));
        }

        $path = Mage::helper('exportorder')->getBaseStorePathForCertificates();
        $path = trim($path, "/\\");
        if (file_exists($path . $this->getOrigData('client_certificate')) && is_file($path . $this->getOrigData('client_certificate'))) {
            if ($this->hasData('client_certificate')) {
                if (($this->getClientCertificate() === null && $this->getOrigData('client_certificate'))
                    || ($this->getClientCertificate() !== $this->getOrigData('client_certificate'))) {
                    @unlink($path . $this->getOrigData('client_certificate'));
                }
            }
        }

        if (file_exists($path . $this->getOrigData('client_ca')) && is_file($path . $this->getOrigData('client_ca'))) {
            if ($this->hasData('client_ca')) {
                if (($this->getClientCa() === null && $this->getOrigData('client_ca'))
                    || ($this->getClientCa() !== $this->getOrigData('client_ca'))) {
                    @unlink($path . $this->getOrigData('client_ca'));
                }
            }
        }
        return parent::_beforeSave(); // TODO: Change the autogenerated stub
    }
}
