<?php
/**
 *
* @category   	Bkg Viewer
* @package    	Bkg_Viewer
* @name       	Bkg_Viewer_Model_Service_Service
* @author 		Holger Kögel <h.koegel@b3-it.de>
* @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
* @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
*/
/**
 *  @method int getId()
*  @method setId(int $value)
*  @method string getTitle()
*  @method setTitle(string $value)
*  @method string getFormat()
*  @method setFormat(string $value)
*  @method string getUrl()
*  @method setUrl(string $value)
*  @method string getUrlFeatureinfo()
*  @method setUrlFeatureinfo(string $value)
*  @method string getUrlMap()
*  @method setUrlMap(string $value)
*/
class Bkg_Viewer_Model_Service_Service extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('bkgviewer/service_service');
	}


	public function fetchLayers($url,$type='WMS')
	{
		$helper = Mage::helper('bkgviewer');
		//try
		{
			$url = trim($url,'?');
			$url .= "?Request=GetCapabilities&SERVICE=".$type."&VERSION=1.3.0";
			$xml = $helper->fetchData($url);
			$wms = new B3it_XmlBind_Wms13_WmsCapabilities();
			$capa = $wms->getCapability();
			$wms->bindXml($xml);
			$this->setUrl($url);
			$this->setTitle($wms->getService()->getTitle()->getValue());
			$this->setUrlFeatureinfo($this->_getHref($capa->getRequest()->getGetfeatureinfo()->getAllDcptype()));
			$this->setUrlMap($this->_getHref($capa->getRequest()->getGetmap()->getAllDcptype()));
			$this->save();

			$layer = $capa->getLayer();
			$this->_saveLayer($layer);
		}
		//     	catch(Exception $ex)
		//     	{
		//     		Mage::logException($ex);
		//     	}
			 
	}

	/**
	 * die UrL Bestimmen
	 * @param array B3it_XmlBind_Wms13_Dcptype $dcp
	 */
	protected function _getHref(array $dcp)
	{
		/* @var B3it_XmlBind_Wms13_Dcptype $d */
		foreach($dcp as $d)
		{
			return $d->getHttp()->getGet()->getOnlineresource()->getAttribute('href');
		}
		 
		return "";
	}

	protected function _saveLayer(B3it_XmlBind_Wms13_Layer $layer, $parent_id = null)
	{
		$model = Mage::getModel('bkgviewer/service_layer');
		$model->setTitle($layer->getTitle()->getValue());
		$model->setName($layer->getName()->getValue());
		$model->setAbstract($layer->getAbstract()->getValue());
		$model->setParentId($parent_id);
		$model->setServiceId($this->getId());
		$model->setCrs();
		$model->setBbWest($layer->getExGeographicboundingbox()->getWestboundlongitude()->getValue());
		$model->setBbEast($layer->getExGeographicboundingbox()->getEastboundlongitude()->getValue());
		$model->setBbSouth($layer->getExGeographicboundingbox()->getSouthboundlatitude()->getValue());
		$model->setBbNorth($layer->getExGeographicboundingbox()->getNorthboundlatitude()->getValue());
		//    	$model->setStyle();
		$model->save();
		 
		 
		foreach($layer->getAllBoundingbox() as $bb)
		{
			/* @var Bkg_Viewer_Model_Service_Crs $mod_crs */
			$mod_crs = Mage::getModel('bkgviewer/service_crs');
			$mod_crs->setName($bb->getAttribute('CRS'));
			$mod_crs->setLayerId($model->getId());
			$mod_crs->setMinx($bb->getAttribute('minx'));
			$mod_crs->setMaxx($bb->getAttribute('maxx'));
			$mod_crs->setMiny($bb->getAttribute('miny'));
			$mod_crs->setMaxy($bb->getAttribute('maxy'));
			$mod_crs->save();

		}
		 
		foreach($layer->getAllLayer() as $ly)
		{
			$this->_saveLayer($ly,$model->getId());
		}

	}

}
