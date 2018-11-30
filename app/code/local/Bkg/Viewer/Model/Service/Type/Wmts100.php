<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Service_Type_Wms
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Bkg_Viewer_Model_Service_Type_Wmts100 extends Bkg_Viewer_Model_Service_Type_Wmts
{
	
	protected $_version = "1.0.0";
	

	protected function _fetchData($url)
	{
	    /**
	     * @var Bkg_Viewer_Helper_Data $helper
	     */
		$helper = Mage::helper('bkgviewer');
		//try
		{
			$url = trim($url,'?');
			$url .= "/{$this->_version}/WMTSCapabilities.xml";
			$xml = $helper->fetchData($url);
		
			$dom = new DOMDocument();
			$dom->loadXML($xml);
			
			$xpath = new DOMXPath($dom);
			
			$this->_serviceData['format'] = $this->_type;
			$this->_serviceData['title']= $xpath->query("//ows:ServiceIdentification/ows:Title")->item(0)->textContent;
			// url need to be to capabilities, because used to auto get the options
			$this->_serviceData['url'] = $url;
			$this->_serviceData['url_featureinfo'] = $url;
			$this->_serviceData['url_map'] = $url;
			
			$layers = array();
			
			
			/**
			 * 
			 * @var DOMNodeList $nodeList
			 */
			$nodeList = $dom->getElementsByTagName("Layer");
			$nb = $nodeList->length;
			
			for($pos=0; $pos<$nb; $pos++) {
			    /**
			     * @var DOMElement $node
			     */
			    $node = $nodeList->item($pos);
			    $res = array();
			    
			    $res['title'] =  $xpath->query("./ows:Title", $node)->item(0)->textContent;
			    $res['name'] = $xpath->query("./ows:Identifier", $node)->item(0)->textContent;
			    $res['abstract'] = "";
			    $res['children'] = array();
			    
			    $layers[] = $res;
			}

			$this->_serviceData['layer'] = $layers;
		}
	}
}
