<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Catalog grouped product info block
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Bkg_MapSeries_Block_Product_View_Type_Mapseries_Map extends Mage_Catalog_Block_Product_View_Abstract
{
	
	
	protected $_composit = null;
	protected $_compositLayers = null;
	
	public function _prepareLayout()
	{
		parent::_prepareLayout();
		$this->setTemplate('catalog/product/view/type/mapseries/map.phtml');
	
		return $this;
	}
	
	/**
	 *
	 * @return array
	 */
	public function getSelectionTools() {
	    $composit = $this->getComposit();
	    if ($composit) {
	        return Mage::getModel('bkgviewer/composit_selectiontools')->getOptions4Product($composit->getId());
	    }
	    return array();
	}
	
	public function getESPGfromTool() {
	    foreach ($this->getSelectionTools() as $tool) {
	        /**
	         * @var Bkg_Viewer_Model_Composit_Selectiontools $tool 
	         */
	        $service = $tool->getService();
	        
	        // currently only works for wfs tools
	        if ($service->getFormat() != "wfs") {
	            continue;
	        }
	        
	        /**
	         * @var Bkg_Viewer_Helper_Data $helper
	         */
	        $helper = Mage::helper("bkgviewer");
	        
	        $data = $helper->fetchData($service->getUrl());
	        if (empty($data)) {
	            continue;
	        }
	        
	        $name = $tool->getServiceLayer()->getName();
	        
	        $dom = new DOMDocument();
	        
	        $dom->loadXML($data);
	        $xpath = new DOMXPath($dom);
	        
	        // check for DefaultSRS value, need to use namespace in query
	        $r = $xpath->query("//wfs:FeatureType[wfs:Name = '".$name."']/wfs:DefaultSRS");
	        if ($r->length < 1) {
	            continue;
	        }
	        
	        /** @var DOMNode $n */
	        $n = $r->item(0);
	        
	        // grep ending number for EPSG code
	        $treffer = array();
	        if (preg_match("/\d+$/", $n->textContent, $treffer)) {
	            return $treffer[0];
	        }
	    }
	    return null;
	}
	
    /**
     * 
     * @return Bkg_Viewer_Model_Composit_Composit
     */
    public function getComposit()
    {
    	if($this->_composit == null){
    		$product = $this->getProduct();
    		if(!$product->getId()){
    			$this->log('Product for Composit not found!');
    			return null;
    		}
    		
    		if(!$product->getGeocomposit()){
    			$this->log('Composit not set!');
    			return null;
    		}
    		
    		$this->_composit = Mage::getModel('bkgviewer/composit_composit')->load($product->getGeocomposit());
    	}
    	
    	return $this->_composit;
    }
    
    public function getCompositLayers()
    {
    	if($this->_compositLayers == null){
    		$product = $this->getProduct();
    		if(!$product->getId()){
    			$this->log('Product for Composit not found!');
    			return array();
    		}
    
    		if(!$product->getGeocomposit()){
    			$this->log('Composit not set!');
    			return array();
    		}
    
    		$collection = Mage::getModel('bkgviewer/composit_layer')->getCollection();
    		$collection->getSelect()
    			->where('composit_id='.intval($product->getGeocomposit()))
    			->order('visual_pos');
    		$this->_compositLayers = $collection->getItems();
    	}
    	 
    	return $this->_compositLayers;
    }
}
