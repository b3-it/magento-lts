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
class Egovs_Paymentbase_Model_Webservice_Soap_Client extends Zend_Soap_Client
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
			//Bei Zertifikatfehlern gibt PHP Soap die Meldung als Warning aus.
			//der SoapClient setzt das error_reporting jedoch immer auf 0 -> siehe mageCoreErrorHandler!
			set_error_handler(array(Mage::helper('paymentbase'), 'epayblErrorHandler'));
			//The documentation about classes/objects misses that you actually can prevent exposing errors in the constructor by using @new
			/** @see http://www.php.net/manual/de/language.operators.errorcontrol.php **/
			$this->_soapClient = @new Zend_Soap_Client_Common(array($this, '_doRequest'), $wsdl, $options);
		} catch (Exception $e) {
			Mage::log(
				sprintf("Error::%s: %s in %s Line: %d", $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine()),
				Zend_Log::ERR,
				Egovs_Helper::EXCEPTION_LOG_FILE
			);
			restore_error_handler();
			throw $e;
		}
		restore_error_handler();
	}
	
	public function __doRequest($request, $location, $action, $version, $one_way = 0)
	{
		$response = parent::__doRequest($request, $location, $action, $version, $one_way);
		// strip away everything but the xml.
		$response = preg_replace('/^.*(<\?xml.*>|<soap\:Envelope.*>)[^>]*$/s', '$1', $response);
		$response = $this->_preProcessXml($response);
		return $response;
	}
	
	protected function _preProcessXml($xmlData) {
		$doc = new DOMDocument; // declare a new DOMDocument Object
		$doc->preserveWhiteSpace = false;
		$doc->loadxml($xmlData); //load the xml request
		
		$doc->formatOutput = true;
		$xmlData = $doc->savexml(); //re-assigned the new XML to $xmlData.
		
		return $xmlData;
	}
}