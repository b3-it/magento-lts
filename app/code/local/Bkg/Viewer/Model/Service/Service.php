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


	public function fetchLayers($url,$type='WMS',$version="1.3.0")
	{
		$helper = Mage::helper('bkgviewer');
		$reader = Mage::getModel('bkgviewer/service_type_'.$type.str_replace('.', '', $version));
		if(!$reader)
		{
			Mage::throwException("Service Reader not found: Type" . $type . " Version " . $version);
		}
		//try
		{
			$url = trim($url,'?');
			$data = $reader->fetchData($url);
			
			$this->setData($data);
			$this->save();

			$layers = $data['layer'];
			foreach ($layers as $layer)
			{
				$this->_saveLayer($layer);
			}
		}
		//     	catch(Exception $ex)
		//     	{
		//     		Mage::logException($ex);
		//     	}
			 
	}

	

	protected function _saveLayer($layer, $parent_id = null)
	{
		//foreach ($layers as $layer)
		{
			$model = Mage::getModel('bkgviewer/service_layer');
			$model->setData($layer);
			$model->setParentId($parent_id);
			$model->setServiceId($this->getId());
			$model->save();
			
			if(isset($layer['children'])){
				foreach($layer['children'] as $ly)
				{
					$this->_saveLayer($ly,$model->getId());
				}
			}
			
		}
		

		 
		 
// 		foreach($layer->getAllBoundingbox() as $bb)
// 		{
// 			/* @var Bkg_Viewer_Model_Service_Crs $mod_crs */
// 			$mod_crs = Mage::getModel('bkgviewer/service_crs');
// 			$mod_crs->setName($bb->getAttribute('CRS'));
// 			$mod_crs->setLayerId($model->getId());
// 			$mod_crs->setMinx($bb->getAttribute('minx'));
// 			$mod_crs->setMaxx($bb->getAttribute('maxx'));
// 			$mod_crs->setMiny($bb->getAttribute('miny'));
// 			$mod_crs->setMaxy($bb->getAttribute('maxy'));
// 			$mod_crs->save();

// 		}
		 
	
		

	}

}
