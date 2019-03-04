<?php
class Egovs_SepaDebitSax_Model_Webservice_Soap_Client extends SoapClient // Zend_Soap_Client
{
	
	public $lastRequest = "";
	public $lastResponse = "" ;
	
	protected $_aAttachments  = array();
	
	public $PDFStream = null;
	
	protected function _preProcessXml($request) {
		$doc = new DOMDocument('1.0', 'UTF-8'); // declare a new DOMDocument Object
		$doc->preserveWhiteSpace = false;
		$doc->loadxml($request); //load the xml request
		
		$xpath = new DOMXPath($doc); //we use DOMXPath to edit the XML Request
		
		foreach( $xpath->query('//*[not(node())]') as $node ) { //create a query, looking a possible empty node(s)
			//20161109::Frank Rochlitzer
			//Nur löschen Falls wirklich leer --> Probleme bei Payplace panalias
			if ($node->hasAttributes()) {
				continue;
			}
			$node->parentNode->removeChild($node); //remove the node
		}
		$doc->formatOutput = true;
		$request = $doc->savexml(); //re-assigned the new XML to $request.
		
		return $request;
	}
	
	
	//der Body fängt nach der ersten Leerzeile an
	public function getEmptyLinePos($xml, $start = 0) {
		$res = null;
		
		for ($i = $start, $iMax = count($xml); $i < $iMax; $i++) {
			if (strlen(trim($xml[$i]))  == 0) {
				$res = $i +1;
				break;
			}
		}
		return $res;
	}
	
	public function __doRequest($request, $location, $action, $version, $one_way = null) {
		$request = $this->_preProcessXml ( $request );
		$this->lastRequest = $request;
		// Workaround für Fehlermedlung: looks like we got no XML document
		// BOM muss entfernt werden!
		// @see http://www.highonphp.com/fixing-soap-exception-no-xml
		
		$response = parent::__doRequest ( $request, $location, $action, $version, $one_way = null );
		
		$xml = explode ( "\r\n", $response );
		
		$pos = $this->getEmptyLinePos ( $xml );
		if (($pos != null) && (count ( $xml ) >= $pos)) {
			$response = preg_replace ( '/^(\x00\x00\xFE\xFF|\xFF\xFE\x00\x00|\xFE\xFF|\xFF\xFE|\xEF\xBB\xBF)/', "", $xml [$pos] );
		}
		
		// nächste LeerZeile
		$posAttachment = $this->getEmptyLinePos ( $xml, $pos );
		if (isset ( $xml [$posAttachment] )) {
			$this->PDFStream = $xml [$posAttachment];
			$posAttachment ++;
			while ( $xml [$posAttachment] != $xml [0] . "--" ) {
				$this->PDFStream .= "\r\n" . $xml [$posAttachment];
				$posAttachment ++;
			}
		}
		
		$response = preg_replace ( "|<MandatPdf>(.*?)</MandatPdf>|si", "", $response, - 1, $count );
		$response = preg_replace ( "|<PreNotificationPdf>(.*?)</PreNotificationPdf>|si", "", $response, - 1, $count );
		$response = preg_replace ( "|<AmendmentPdf>(.*?)</AmendmentPdf>|si", "", $response, - 1, $count );
		
		$this->lastResponse = $this->_preProcessXml ( $response );
		$this->logLastRequest ();
		
		return $response;
	}

	public function logLastRequest() {
		Mage::log(
				sprintf(
						"soapCommunication::\nRequest:\n%s\nResponse:\n%s",
						$this->lastRequest,
						$this->lastResponse
				),
				Zend_Log::DEBUG,
				Egovs_Helper::LOG_FILE
		);
	}
	
	public function logLastError() {
		Mage::log(
				sprintf(
						"soapCommunicationError::\nRequest:\n%s\nResponse:\n%s",
						$this->lastRequest,
						$this->lastResponse
				),
				Zend_Log::ERR,
				Egovs_Helper::EXCEPTION_LOG_FILE
		);
	}
	
	public function __getLastRequest () {
		if (!empty($this->lastRequest)) {
			return $this->lastRequest;
		}
		return parent::__getLastRequest();
	}
	
	public function __getLastResponse() {
		if (!empty($this->lastResponse)) {
			return $this->lastResponse;
		}
		
		return parent::__getLastResponse();
	}
}