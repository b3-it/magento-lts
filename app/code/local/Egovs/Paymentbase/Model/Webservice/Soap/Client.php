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
}