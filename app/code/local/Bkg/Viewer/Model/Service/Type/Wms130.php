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

class Bkg_Viewer_Model_Service_Type_Wms130 extends Bkg_Viewer_Model_Service_Type_Wms
{
	
	protected $_version = "1.3.0";
	

	protected function _fetchData($url)
	{
		$helper = Mage::helper('bkgviewer');
		//try
		{
			$url = trim($url,'?');
			$url .= "?Request=GetCapabilities&SERVICE=".$this->_type."&VERSION=".$this->_version;
			$xml = $helper->fetchData($url);
			$wms = new B3it_XmlBind_Wms13_WmsCapabilities();
			$capa = $wms->getCapability();
			$wms->bindXml($xml);
			
			$this->_serviceData['url'] = $url;
			$this->_serviceData['format'] = $this->_type;
			$this->_serviceData['title']=($wms->getService()->getTitle()->getValue());
			$this->_serviceData['url_featureinfo'] = ($this->_getHref($capa->getRequest()->getGetfeatureinfo()->getAllDcptype()));
			$this->_serviceData['url_map'] = ($this->_getHref($capa->getRequest()->getGetmap()->getAllDcptype()));
			
			$layers = array();
			$layers[] = $this->_getLayer($capa->getLayer());
			$this->_serviceData['layer'] = $layers;
		
			
		}
	}
	
	protected function _getLayer($layer)
	{
		$res = array();
		
		$res['title'] = ($layer->getTitle()->getValue());
		$res['name'] =($layer->getName()->getValue());
		$res['abstract'] =($layer->getAbstract()->getValue());
		
		$res['bb_west'] = $layer->getExGeographicboundingbox()->getWestboundlongitude()->getValue();
		$res['bb_east'] = $layer->getExGeographicboundingbox()->getEastboundlongitude()->getValue();
		$res['bb_south'] = $layer->getExGeographicboundingbox()->getSouthboundlatitude()->getValue();
		$res['bb_north'] = $layer->getExGeographicboundingbox()->getNorthboundlatitude()->getValue();
		
		$res['children'] = array();
		
		foreach ($layer->getAllLayer() as $l)
		{
			$res['children'][] = $this->_getLayer($l);
		
		}
		
		
		
		return $res;
	}
	
	
	
}
