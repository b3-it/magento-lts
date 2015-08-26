<?php
/**
 * Basisklasse für ePayBL Webservice SOAP Client
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2012 -2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Webservice_Soap_Client extends Zend_Soap_Client
{
	/**
	 * Initialize SOAP Client object
	 *
	 * @see http://de.php.net/manual/en/class.soapclient.php#104046
	 *  
	 * @return void
	 * 
	 * @throws Zend_Soap_Client_Exception
	 */
	protected function _initSoapClientObject()
	{
		$wsdl = $this->getWsdl();
		//The exceptions option is a boolean value defining whether soap errors throw exceptions of type
		$options = array_merge($this->getOptions(), array('trace' => true, "exceptions" => true));
	
		if ($wsdl == null) {
			if (!isset($options['location'])) {
				//require_once 'Zend/Soap/Client/Exception.php';
				throw new Zend_Soap_Client_Exception('\'location\' parameter is required in non-WSDL mode.');
			}
			if (!isset($options['uri'])) {
				//require_once 'Zend/Soap/Client/Exception.php';
				throw new Zend_Soap_Client_Exception('\'uri\' parameter is required in non-WSDL mode.');
			}
		} else {
			if (isset($options['use'])) {
				//require_once 'Zend/Soap/Client/Exception.php';
				throw new Zend_Soap_Client_Exception('\'use\' parameter only works in non-WSDL mode.');
			}
			if (isset($options['style'])) {
				//require_once 'Zend/Soap/Client/Exception.php';
				throw new Zend_Soap_Client_Exception('\'style\' parameter only works in non-WSDL mode.');
			}
		}
		unset($options['wsdl']);
	
		try {
			//The documentation about classes/objects misses that you actually can prevent exposing errors in the constructor by using @new
			//Funktioniert @new nur in PHP 5.3?
			/** @see http://www.php.net/manual/de/language.operators.errorcontrol.php **/
			$this->_soapClient = @new Zend_Soap_Client_Common(array($this, '_doRequest'), $wsdl, $options);
		} catch (Exception $e) {
			Mage::log(
				sprintf("Error::%s: %s in %s Line: %d", $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine()),
				Zend_Log::ERR,
				Egovs_Helper::EXCEPTION_LOG_FILE
			);
			throw $e;
		}
	}
	
	
	
	public function __call($name, $arguments)
	{
		try {
			return parent::__call($name, $arguments);
		}
		catch(Exception $ex)
		{
			return $ex;
		}
	}
	
	function getOptions() {
		$options = parent::getOptions();
		if (is_integer($this->_connection_timeout)) {
			$options["connection_timeout"] = $this->_connection_timeout;
		}
		return $options;
	}
	
	public function _doRequest(Zend_Soap_Client_Common $client, $request, $location, $action, $version, $one_way = null) {
		//if (!is_integer($this->_connection_timeout)) {
		//	return parent::_doRequest($client, $request, $location, $action, $version, $one_way);
		//} else 
		{
			$curl = curl_init($location);
			curl_setopt($curl, CURLOPT_VERBOSE, FALSE);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curl, CURLOPT_POST, TRUE);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
			curl_setopt($curl, CURLOPT_HEADER, FALSE);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			$password = $this->getHttpPassword();
			if ($password) {
				curl_setopt($curl, CURLOPT_USERPWD, "{$this->getHttpLogin()}:$password");
				curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			}
			
			Mage::log('ICD:: Request '.$request,Zend_Log::DEBUG,Egovs_Helper::LOG_FILE);
			$response = curl_exec($curl);
			Mage::log('ICD:: Response '.$response,Zend_Log::DEBUG,Egovs_Helper::LOG_FILE);
			if (curl_errno($curl)) {
				throw new Exception(curl_error($curl));
			}
			curl_close($curl);
			if (!$one_way) {
				return ($response);
			}
		}
	}
}