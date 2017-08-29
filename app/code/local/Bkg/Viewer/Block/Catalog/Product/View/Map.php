<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Composit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Catalog_Product_View_Map extends Mage_Catalog_Block_Product_View_Abstract
{
	protected $_composit = null;
	protected $_compositLayers = null;
	
	public function _prepareLayout()
    {
		parent::_prepareLayout();
		$this->setTemplate('bkg/viewer/catalog/product/view/map.phtml');
		
		return $this;
    }

    public function getTileSystem()
    {
    	$comp = $this->getComposit();
    	if($comp){
    		$ts =Mage::getModel('bkgviewer/service_tilesystem');
    		$ts->load($comp->getTileSystem());
    		
    		return $ts;
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
