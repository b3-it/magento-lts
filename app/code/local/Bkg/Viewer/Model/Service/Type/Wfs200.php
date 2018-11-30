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

class Bkg_Viewer_Model_Service_Type_Wfs200 extends Bkg_Viewer_Model_Service_Type_Wfs
{
	
	protected $_version = "2.0.0";

	
	
	protected function _fetchData($url)
	{
		$helper = Mage::helper('bkgviewer');
		//try
		{
			$url = trim($url,'?');
			$url .= "?Request=GetCapabilities&SERVICE=".$this->_type."&VERSION=".$this->_version;
			$xml = $helper->fetchData($url);
			
			$doc = simplexml_load_string($xml);
			$ns = $doc->getNamespaces(true);
			
			$this->_serviceData['url'] = $url;
			$this->_serviceData['format'] = $this->_type;
			$this->_serviceData['url_map'] = $url;
			
			$this->setUrl($url);
			
			$si = $doc->children($ns['ows'])->ServiceIdentification;
			$this->_serviceData['title'] = (string)$si->children($ns['ows'])->Title;
			
			$layer = array();
			
			foreach($doc->FeatureTypeList->FeatureType as $ft)
			{
				$layer[] = array('name'=> (string)$ft->Name, 'title'=>(string)$ft->Title);
			}
		
			$this->_serviceData['layer'] = $layer;

		}
		return $this;
	}
	
	
	
	
}
