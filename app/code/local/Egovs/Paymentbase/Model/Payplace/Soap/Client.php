<?php
class Egovs_Paymentbase_Model_Payplace_Soap_Client extends SoapClient
{
	protected function _preProcessXml($request)
	{
		$doc = new DOMDocument; // declare a new DOMDocument Object
		$doc->preserveWhiteSpace = false;
		$doc->loadxml($request); //load the xml request
	
		$xpath = new DOMXPath($doc); //we use DOMXPath to edit the XML Request
	
		//create a query, looking a possible empty node(s)
		/** @var $node DOMNode */
		foreach ($xpath->query('//*[not(node())]') as $node ) {
			//20161109::Frank Rochlitzer
			//Nur löschen Falls wirklich leer --> Probleme bei Payplace panalias
			if ($node->hasAttributes()) {
				continue;
			}
			$node->parentNode->removeChild($node); //remove the node
		}
		
		foreach ($xpath->query('//ns1:formServiceRequest/ns1:bankAccount') as $node ) { //create a query, looking a possible empty node(s)
			if (!$node->hasAttribute('xsi:type')) {
				continue;
			}
			$node->removeAttribute('xsi:type'); //remove the node
		}
		$doc->formatOutput = true;
		$request = $doc->savexml(); //re-assigned the new XML to $request.
	
		return $request;
	}
	
	public function __doRequest($request, $location, $action, $version, $one_way = null) {	
		$request = $this->_preProcessXml($request);
		$this->lastRequest = $request;
		//Workaround für Fehlermedlung: looks like we got no XML document
		//BOM muss entfernt werden!
		//@see http://www.highonphp.com/fixing-soap-exception-no-xml
	
		$response = parent::__doRequest($request, $location, $action, $version, $one_way = null);
		
		return $response;
	}
	
	public function __soapCall($function_name, array $arguments, array $options = null, $input_headers = null, array &$output_headers = null) {
		return parent::__soapCall($function_name, $arguments, $options, $input_headers, $output_headers);
	}
	
	public function __call ($function_name, $arguments) {
		return parent::__call($function_name, $arguments);
	}
}