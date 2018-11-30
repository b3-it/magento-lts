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

class Bkg_Viewer_Model_Service_Type_Wfs110 extends Bkg_Viewer_Model_Service_Type_Wfs
{
	
	protected $_version = "1.1.0";

	
	
	protected function _fetchData($url)
	{
	    /**
	     * @var Bkg_Viewer_Helper_Data $helper
	     */
		$helper = Mage::helper('bkgviewer');
		//try
		{
			$url = trim($url,'?');
			$fetchUrl = $url . "?Request=GetCapabilities&SERVICE=".$this->_type."&VERSION=".$this->_version;
			$xml = $helper->fetchData($fetchUrl);
			
			if (empty($xml)) {
			    throw new Exception("fetch data empty");
			}
			$dom = new DOMDocument();
			$dom->loadXML($xml);
			
			$root = $dom->documentElement;
			if ($root == null) {
			    throw new Exception("no root");
			}
			if ($root->tagName !== "wfs:WFS_Capabilities") {
			    throw new Exception("wrong xml data");
			}
			if ($root->getAttribute('version') !== $this->_version) {
			    throw new Exception("wrong version");
			}
			
			$xpath = new DOMXPath($dom);
			
			$this->_serviceData['url'] = $fetchUrl;
			$this->_serviceData['format'] = $this->_type;
			$this->_serviceData['url_map'] = $url;
			// TODO FeatureInfo might not be the best value for GetFeature
			$this->_serviceData['url_featureinfo'] = $url . "?request=GetFeature&SERVICE=".$this->_type."&VERSION=".$this->_version;
			$this->_serviceData['title']= $xpath->query("//ows:ServiceIdentification/ows:Title")->item(0)->textContent;
			
			$layers = array();
			
			/**
			 *
			 * @var DOMNodeList $nodeList
			 */
			$nodeList = $dom->getElementsByTagName("FeatureType");
			$nb = $nodeList->length;
			
			for($pos=0; $pos<$nb; $pos++) {
			    /**
			     * @var DOMElement $node
			     */
			    $node = $nodeList->item($pos);
			    $res = array();
			    
			    $res['title'] =  $xpath->query("./wfs:Title", $node)->item(0)->textContent;
			    $res['name'] = $xpath->query("./wfs:Name", $node)->item(0)->textContent;
			    $res['abstract'] = "";
			    $res['children'] = array();
			    
			    $layers[] = $res;
			}
			
			$this->_serviceData['layer'] = $layers;

		}
		return $this;
	}
	
	
	
	
}
