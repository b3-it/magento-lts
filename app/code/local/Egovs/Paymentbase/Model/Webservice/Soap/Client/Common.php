<?php
class Egovs_Paymentbase_Model_Webservice_Soap_Client_Common extends Zend_Soap_Client_Common
{
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
	public function _doRequest($request, $location, $action, $version, $one_way = null) {
		$response = SoapClient::__doRequest($request, $location, $action, $version, $one_way);
		
		$response = $this->_preProcessResult($response);
		return $response;
	}
	
	/**
	 * Perform result pre-processing
	 *
	 * @param array $result Server response String
	 *
	 * @return string
	 */
	protected function _preProcessResult($result) {
		// strip away everything but the xml.
		$result = preg_replace('/^.*(<\?xml.*>|<soap\:Envelope.*>)[^>]*$/s', '$1', $result);
		$result = $this->_preProcessXml($result);
		return $result;
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