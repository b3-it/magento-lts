<?php
/**
 * Basisklasse für ePayBL Webservice SOAP Client
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 -2017 B3 IT Systeme GmbH https://www.b3-it.de
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
			$this->_soapClient = @new Egovs_Paymentbase_Model_Webservice_Soap_Client_Common(array($this, '_doRequest'), $wsdl, $options);
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
	
	/**
	 * Do request proxy method.
	 *
	 * May be overridden in subclasses
	 *
	 * @internal
	 * @param Zend_Soap_Client_Common $client
	 * @param string $request
	 * @param string $location
	 * @param string $action
	 * @param int    $version
	 * @param int    $one_way
	 * @return mixed
	 */
	public function _doRequest(Zend_Soap_Client_Common $client, $request, $location, $action, $version, $one_way = null)
	{
		// Perform request as is
		if ($one_way == null) {
			return call_user_func(array($client,'_doRequest'), $request, $location, $action, $version);
		} else {
			return call_user_func(array($client,'_doRequest'), $request, $location, $action, $version, $one_way);
		}
	}
}