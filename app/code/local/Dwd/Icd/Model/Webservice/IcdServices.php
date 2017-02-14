<?php
/**
 * Dwd Icd
 *
 * Abhängigkeit zu Egovs_Paymentbase beachten!
 * 
 * @method SoapFault|Dwd_Icd_Model_Webservice_Types_Response_LdapStatus addUser(string $login, string $password)
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Account
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Webservice_IcdServices extends Varien_Object
{
	static public $ICD_NAMESPACE = 'https://kunden.dwd.de/dwdshop/services';
	
	/**
	 * SOAP Client
	 *
	 * @var Zend_Soap_Client
	 */
	protected $_soapClient = null;
	
	/**
	 * Mapped die WSDL Klassen zu PHP-Klassen
	 *
	 * Funktioniert nur im WSDL-Modus des SoapClients
	 * Beim Mapping wird die erste gefunden Klasse genutzt. Dies gilt auch für die Rückrichtung von Value => Key.
	 * Z. B. wird für Dwd_Icd_Model_Webservice_Types_Request_Default => addGroup als Typ genutzt. Da addGroup allerdings genau 2
	 * Argeumente hat, kommt es mit addUser nicht in Konflikt!
	 *
	 * @var array
	 */
	protected $_classmap = array(
			'addAttributeNameValuePair' =>'Dwd_Icd_Model_Webservice_Types_Request_AttributeNameValuePair',
			'addAttributeNameValuePairResponse' => 'Dwd_Icd_Model_Webservice_Types_Response_Default',
			'addGroup' => 'Dwd_Icd_Model_Webservice_Types_Request_Default',
			'addGroupResponse' => 'Dwd_Icd_Model_Webservice_Types_Response_Default',
			'addUser' => 'Dwd_Icd_Model_Webservice_Types_Request_Default',
			'addUserResponse' => 'Dwd_Icd_Model_Webservice_Types_Response_Default',
			'addUserGroupsAttibuteNameValuePairs' => 'Dwd_Icd_Model_Webservice_Types_Request_Default',
			'addUserGroupsAttibuteNameValuePairsResponse' => 'Dwd_Icd_Model_Webservice_Types_Response_Default',			
			'attributeNameValuePair' => 'Dwd_Icd_Model_Webservice_Types_AttributeNameValuePair',
			'ldapStatus' => 'Dwd_Icd_Model_Webservice_Types_Response_LdapStatus',
			'removeAttributeNameValuePair' => 'Dwd_Icd_Model_Webservice_Types_Request_AttributeNameValuePair',
			'removeAttributeNameValuePairResponse'=> 'Dwd_Icd_Model_Webservice_Types_Response_Default',
			'removeGroup' => 'Dwd_Icd_Model_Webservice_Types_Request_Default',
			'removeGroupResponse' => 'Dwd_Icd_Model_Webservice_Types_Response_Default',
			'removeUser'	=> 'Dwd_Icd_Model_Webservice_Types_Request_Default',
			'removeUserResponse' => 'Dwd_Icd_Model_Webservice_Types_Response_Default',
			'setPasswordUser'	=> 'Dwd_Icd_Model_Webservice_Types_Request_Default',
			'setPasswordUserResponse' => 'Dwd_Icd_Model_Webservice_Types_Response_Default',			
	);
	
	protected $_deniedMethods = array (
			'_getClientCertificate', '_getSoapClient, _writeLog', '_parseCallingMethodName', '_toSoapParam',
			'_getCaCertificate',
	);
	
	protected $_uri = null;
	protected $_location = null;
	protected $_options = array();
	protected $_clientCert = null;
	protected $_caCert = null;
	
	/**
	 * Liefert das Client-Certifiacte
	 *
	 * @return string
	*/
	protected function _getClientCertificate() {
		if ($this->_clientCert == null) {
// 			$this->_clientCert = Mage::getStoreConfig('payment_services/paymentbase/client_certificate');
			
// 			$this->_clientCert = Mage::getBaseDir().$this->_clientCert;
		}
	
		return $this->_clientCert;
	}
	
	/**
	 * Liefert das CA-Certifiacte
	 *
	 * @return string
	 */
	protected function _getCaCertificate() {
		if ($this->_caCert == null) {
// 			$this->_caCert = Mage::getStoreConfig('payment_services/paymentbase/ca_certificate');
			
// 			$this->_caCert = Mage::getBaseDir().$this->_caCert;
		}
	
		return $this->_caCert;
	}
	
	protected function _parseCallingMethodName($method) {
		//Führenden '_' entfernen
		if (($pos = strpos($method, '::_')) !== false && $pos+3 < strlen($method)) {
			$method = substr($method, $pos+3);
		}
	
		return $method;
	}
	
	/**
	 * Wandelt die Parameter in SoapParam um
	 *
	 * @param array $parameter Assoziatives Array
	 *
	 * @return array
	 */
	protected function _toSoapParam($parameter) {
		foreach ($parameter as $key => $value) {
			if ($value instanceof Dwd_Icd_Model_Webservice_Types_Abstract) {
				$parameter[$key] = $value->toSoap();
			} elseif (is_float($value)) {
				//Float muss als XSD:DECIMAL übergeben werden!
				$parameter[$key] = new SoapVar($value, XSD_DECIMAL);
			} elseif (is_string($value)){
				$parameter[$key] = new SoapVar($value,XSD_ANYTYPE,XSD_STRING);
			}
			
				
			if (is_string($key)) {
				$parameter[] = new SoapParam($parameter[$key], $key);
			} else {
				$parameter[] = $parameter[$key];
			}
			unset($parameter[$key]);
		}
	
		return $parameter;
	}
	
	/**
	 * Liefert den Stream Context für SSL
	 *
	 * @return resource
	 */
	protected function _getStreamContext() {
		$context = array(
			'ssl' => array(
					'verify_peer' => false,
					'cafile' => $this->_getCaCertificate(),
					'local_cert' => $this->_getClientCertificate(),
					'SNI_enabled' => false
			)
		);
		foreach ($context['ssl'] as $key => $value) {
			if (empty($value)) {
				unset($context['ssl'][$key]);
			}
		}
		return stream_context_create(
				$context
		);
	}
	
	/**
	 * Gibt den SOAP Client zurück
	 *
	 * @return Zend_Soap_Client
	 */
	protected function _getSoapClient() {
		if (!$this->_soapClient) {
	
			$options = array();
			$options = array_merge($options, $this->_options);
			
			
			if ($this->_getClientCertificate()) {
				$options['local_cert'] = $this->_getClientCertificate();
			}
			if (Mage::getStoreConfig('web/proxy/use_proxy') == true) {
				$proxyHost = Mage::getStoreConfig('web/proxy/proxy_name');
				$proxyPort = Mage::getStoreConfig('web/proxy/proxy_port');
				$proxyUser = Mage::getStoreConfig('web/proxy/proxy_user');
				$proxyPass = Mage::getStoreConfig('web/proxy/proxy_user_pwd');
				
				
				$options['proxy_port'] = trim($proxyPort);
				$options['proxy_host'] = trim($proxyHost);
				$options['proxy_login'] = trim($proxyUser);
				$options['proxy_password'] = trim($proxyPass);
				
				Egovs_Paymentbase_Helper_Data::checkForProxyExcludes($this->_location, $options);
			}
			
			if(!isset($options['cache_wsdl']))
			{
				$options['cache_wsdl'] = WSDL_CACHE_MEMORY;
			}
			$options['stream_context'] = $this->_getStreamContext();
			
								
			$this->_soapClient = new Dwd_Icd_Model_Webservice_Soap_Client($this->_location.'?wsdl', $options);
			

			$this->_soapClient->setSoapVersion(SOAP_1_1);
			$this->_soapClient->setClassmap($this->_classmap);
		}
	
		return $this->_soapClient;
	}
	
	
	

	
	/**
	 * Konstruktor
	 *
	 * @return void
	 */
	public function __construct() {
		$args = func_get_args();

		/*
		if (empty($args[0])) {
			Mage::throwException(Mage::helper('dwd_icd')->__('No service location available, please check the configuration.'));
		}
	*/
		if (count($args) > 1 && empty($args[1])) {
			$args[1] = array();
		} elseif (count($args) < 2) {
			$args[1] = array();
		}
	
		$this->_location = $args[0][0];
		$this->_uri = self::$ICD_NAMESPACE;
		$this->_options = $args[0][1];
	}
	
	
	public function isAlive()
	{
		$this->_soapClient == null;
		$this->_options['cache_wsdl'] = WSDL_CACHE_NONE;
		//$this->_getSoapClient()->setWsdlCache(null);
		$this->_getSoapClient()->getFunctions();
		
	}
	
	private function getTimeout()
	{
		return 5;
	}
	
	/**
	 * Set/Get attribute wrapper
	 *
	 * @param string $method Methodenname
	 * @param array $args    Parameter
	 *
	 * @return mixed
	 */
	public function __call($method, $args) {
		if (array_search(sprintf("_%s", $method), $this->_deniedMethods) === false && method_exists($this, sprintf("_%s", $method))) {
				
			try {
				$erg = call_user_func_array(array($this, sprintf("_%s", $method)), $args);
				if (isset($erg->return)) {
					$erg  = $erg->return;
				}
			} catch (Exception $e) {
				Mage::log(
					sprintf("Exception::%s\nsoap::RequestHeader:%s\nRequest:\n%s\nResponse:\n%s",
						$e->__toString(),
						$this->_getSoapClient()->getLastRequestHeaders(),
						$this->_getSoapClient()->getLastRequest(),
						$this->_getSoapClient()->getLastResponse()
					),
					Zend_Log::ERR,
					Egovs_Helper::EXCEPTION_LOG_FILE
				);
				throw $e;
			}
			if (Mage::getStoreConfig('dev/log/log_level') == Zend_Log::DEBUG) {
				Mage::log(
					sprintf("soap::Request:\n%s\nResponse:\n%s",
						$this->_getSoapClient()->getLastRequest(),
						$this->_getSoapClient()->getLastResponse()
					),
					Zend_Log::DEBUG,
					Egovs_Helper::LOG_FILE
				);
			}
	
			if ($erg instanceof SoapFault) {
				$this->_writeLog($method, 'SOAP-Error: ' . $erg->getMessage());
			} else {
				if (isset($erg) && isset($erg->successStatus)) {
					$this->_writeLog($method, "SuccessStatus: {$erg->successStatus}, Nachricht: {$erg->statusMessage}");
				} else {
					$this->_writeLog($method, 'Unkown error');
				}
			}
	
			return $erg;
		}
	
		return parent::__call($method, $args);
	}
	
	protected function _writeLog($method, $message) {
		return $this;
	}
	
	protected function _addAttributeNameValuePair($loginName, $array) {
		//throw new Exception('Implement me!');
		$au = Mage::getModel('dwd_icd/webservice_types_request_attributeNameValuePair', array($loginName, $array));
		$erg =  $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), array($au));
		
		return $erg;
	}
	
	protected function _removeAttributeNameValuePair($loginName, $array) {
		//throw new Exception('Implement me!');
		$au = Mage::getModel('dwd_icd/webservice_types_request_attributeNameValuePair', array($loginName, $array));
		$erg =  $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), array($au));
	
		return $erg;
	}
	protected function _addGroup($loginName, $application) {
		$au = Mage::getModel('dwd_icd/webservice_types_request_default', array($loginName, $application));
		$erg =  $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), array($au));
				
		return $erg;
	}
	
	protected function _addUser($loginName, $password) {
		$au = Mage::getModel('dwd_icd/webservice_types_request_default', array($loginName, $password));
		$erg =  $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), array($au));
		
		return $erg;
	}

	protected function _setPasswordUser($loginName, $password) {
		$au = Mage::getModel('dwd_icd/webservice_types_request_default', array($loginName, $password));
		$erg =  $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), array($au));
		
		return $erg;
	}
	
	protected function _removeUser($loginName) {
		$au = Mage::getModel('dwd_icd/webservice_types_request_default', $loginName);
		$erg = $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), array($au));
	
		return $erg;
	}
	
	protected function _removeGroup($loginName, $application) {
		$au = Mage::getModel('dwd_icd/webservice_types_request_default', array($loginName, $application));
		$erg =  $this->_getSoapClient()->__call($this->_parseCallingMethodName(__METHOD__), array($au));
	
		return $erg;
	}
}